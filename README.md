
# Laravel-Messenger
Laravel Internal Messaging Package - basically copy of https://github.com/cmgmyr/laravel-messenger


## Installation
```
composer require stobys/laravel-messenger
```

Add the service provider to `config/app.php` under `providers`:
```php
'providers' => [
    SylveK\LaravelMessenger\LaravelMessengerServiceProvider::class,
],
```

> **Note**: With Laravel 5.5 and higher you can skip this step. Laravel Messenger supports [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

Publish config:
```
php artisan vendor:publish --provider="SylveK\LaravelMessenger\LaravelMessengerServiceProvider" --tag="config"
```

Update config file to reference your User Model:
```
config/messenger.php
```

Publish migrations:
```
php artisan vendor:publish --provider="SylveK\LaravelMessenger\LaravelMessengerServiceProvider" --tag="migrations"
```

Migrate your database:
```
php artisan migrate
```

Add the trait to your user model:
```php
use SylveK\LaravelMessenger\Traits\Messagable;

class User extends Authenticatable {
    use Messagable;
}
```

## Security
If you happen to discover any security related issues, please email [me](mailto:s.tobys@gmail.com) instead of using the issue tracker.


### Special Thanks
This package used [cmgmyr/laravel-messenger](https://github.com/cmgmyr/laravel-messenger) as a starting point.


### License
The Laravel Messenger is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

