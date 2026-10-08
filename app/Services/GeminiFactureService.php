<?php

namespace App\Services;

use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;

class GeminiFactureService
{
    public function extraire(string $filePath, string $extension, string $prompt): ?array
    {
        $mimeType = match ($extension) {
            'png' => MimeType::IMAGE_PNG,
            'jpg', 'jpeg' => MimeType::IMAGE_JPEG,
            default => MimeType::APPLICATION_PDF,
        };

        $fileBlob = new Blob(
            mimeType: $mimeType,
            data: base64_encode(file_get_contents($filePath))
        );

        $modeles = config('services.gemini.models');
        $essaisParModele = 2;

        foreach ($modeles as $modele) {
            for ($essai = 1; $essai <= $essaisParModele; $essai++) {
                try {
                    $response = Gemini::generativeModel(model: $modele)
                        ->generateContent([$prompt, $fileBlob]);

                    $jsonText = trim($response->text());
                    Log::info('Réponse brute Gemini', ['modele' => $modele, 'texte' => $jsonText]);

                    $jsonText = preg_replace('/^```json\s*/i', '', $jsonText);
                    $jsonText = preg_replace('/^```\s*/i', '', $jsonText);
                    $jsonText = preg_replace('/\s*```$/i', '', $jsonText);

                    $data = json_decode(trim($jsonText), true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                        return $data;
                    }

                    Log::error("Gemini ($modele) réponse non JSON valide : " . $jsonText);

                } catch (\Throwable $e) {
                    Log::error("Erreur Gemini API ($modele, essai $essai) : " . $e->getMessage());

                    if (!$this->erreurTemporaire($e)) {
                        break; // erreur définitive : inutile de réessayer ce modèle
                    }

                    if ($essai < $essaisParModele) {
                        sleep(2 * $essai);
                    }
                }
            }

            Log::warning("Gemini : modèle $modele indisponible, passage au suivant.");
        }

        return null;
    }

    private function erreurTemporaire(\Throwable $e): bool
    {
        $msg = strtolower($e->getMessage());

        foreach (['high demand', 'overloaded', 'unavailable', 'resource_exhausted',
                  'quota', 'rate limit', 'try again', 'timed out', 'timeout'] as $mot) {
            if (str_contains($msg, $mot)) {
                return true;
            }
        }

        return in_array((int) $e->getCode(), [429, 500, 502, 503, 504], true);
    }
}