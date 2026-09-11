Annuler la dernière migration
    php artisan migrate:rollback
Annuler toutes les migrations
    php artisan migrate:reset
Annuler puis réexécuter toutes les migrations
    php artisan migrate:refresh
Annuler puis réexécuter toutes les migrations    
    php artisan migrate:refresh --seed

Reedit database
 php artisan migrate:fresh 

mandefa en ligne 
cloudflared tunnel --url http://localhost:8000

mijery log farany 
powershell -Command "Get-Content storage\logs\laravel.log -Tail 50"

mijery log en tant reel
powershell -Command "Get-Content storage\logs\laravel.log -Tail 50 -Wait"

nouveau bibiliotheque 
//mi analyse sy resaka generation pdf 
    composer require smalot/pdfparser

Installation an SDK Gemini dans Laravel
    composer require google-gemini-php/laravel:^2.0
    composer require google-gemini-php/laravel



Vider la cache 
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    php artisan event:clear
    php artisan optimize:clear

