
@echo off
title Application Comptabilite Laravel
color 0A

echo ==========================================
echo    DEMARRAGE DE L'APPLICATION LARAVEL
echo ==========================================
echo.

cd /d "C:\Users\Romeo\Documents\Comptable\Projet-Comptable"

if not exist artisan (
    echo ERREUR : Dossier Laravel introuvable.
    pause
    exit /b 1
)

echo [1/3] Verification de Laravel...
php artisan --version
if errorlevel 1 (
    echo ERREUR : PHP n'est pas accessible dans le PATH.
    echo Ajoutez le chemin PHP de XAMPP au PATH ou utilisez son chemin complet.
    pause
    exit /b 1
)

echo.
echo [2/3] Demarrage du serveur Laravel...
echo.
echo L'application sera disponible sur :
echo http://127.0.0.1:8000
echo.
echo Gardez cette fenetre ouverte pendant l'utilisation.
echo.

php artisan serve --host=127.0.0.1 --port=8000

pause
