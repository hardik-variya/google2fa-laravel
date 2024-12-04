# laravel 11 Impersonate
This demo project demonstrates how to implement Google 2FA in Laravel for enhanced security. Learn step-by-step integration of Google Authenticator for two-factor authentication (2FA) in Laravel 6-11. It uses Google2FA for TOTP and HOTP algorithms, ensuring robust protection for your app. Perfect for securing user accounts with ease.


## Contact:
[![image](https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:variyahardik11@gmail.com)
[![image](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/hardik-variya)
[![image](https://img.shields.io/badge/UpWork-6FDA44?style=for-the-badge&logo=Upwork&logoColor=white)](https://www.upwork.com/freelancers/variyahardik)


## Documents:

Laravel Document : https://laravel.com/docs/11.x/

google2fa laravel Git: https://github.com/antonioribeiro/google2fa-laravel

BaconQr Code Git : https://github.com/Bacon/BaconQrCode

## Installation:

1. Create Project:
```
composer create-project laravel/laravel laravel-11-example

```

2. Install Breeze:
```
composer require laravel/breeze

php artisan breeze:install
```

3. Require it with Composer:
```
composer require pragmarx/google2fa-laravel

composer require bacon/bacon-qr-code

php artisan vendor:publish --provider="PragmaRX\Google2FALaravel\ServiceProvider"

```

4. Create Middleware and migration:
```
php artisan make:middleware Google2FA

php artisan make:migration add_google_2fa_columns
```

5. Google2FA Middleware code:
```
$authenticator = app(Authenticator::class)->boot($request);

if ($authenticator->isAuthenticated() || \Auth::user()->google2fa_enable == 0) {
    return $next($request);
}

return $authenticator->makeRequestOneTimePasswordResponse();

```

6. Migration Code:
```
 Schema::table('users', function (Blueprint $table) {
    $table->integer('google2fa_enable')->default(0)->after('remember_token');
    $table->text('google2fa_secret')->nullable()->after('remember_token');
});
```


7. Define Middleware:
```

app/Http/Kernel.php

protected $routeMiddleware = [
    ...

    '2fa' => Google2FA::class,

];


For Larvel 11 

bootstrap/app.php

->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            '2fa' => Google2FA::class,
        ]);

    })
```

8. Configure database connection:

```
Edit .env file according to your database credentials.

DB_DATABASE=laravel_google2fa
DB_USERNAME=root
DB_PASSWORD=
```

10. Migrate database tables
```
php artisan migrate
```

11. Start development server
```
npm install
npm run dev
php artisan serve
```

## Photos
![Spec Coder](https://i.postimg.cc/CLtdKNQv/google2fa-laravel-1.png)
#
![Spec Coder](https://i.postimg.cc/qMngznH4/google2fa-laravel-2.png)
#
![Spec Coder](https://i.postimg.cc/0N3qYW73/google2fa-laravel-3.png)
#
![Spec Coder](https://i.postimg.cc/Ss0vQw6y/google2fa-laravel-4.png)
#
![Spec Coder](https://i.postimg.cc/pXyY7sjk/google2fa-laravel-5.png)
