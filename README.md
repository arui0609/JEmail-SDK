<h1 align="center">JCloud Email</h1>

A Simple SDK for Sjtu Email Service

## Installation

Package is available on Packagist, you can install it using Composer.

> composer require arui/j-email

### Dependencies

- PHP 7.3+
- OpenSSL Extension
- Laravel 6+

### Parameter setting
>   php artisan vendor publish  --provider="Arui\JEmail\JEmailProvider"

.env

``` 
 JCLOUD_EMAIL_CLIENT_ID=
 JCLOUD_EMAIL_CLIENT_SECRET=
 JCLOUD_EMAIL_USERNAME=
 JCLOUD_EMAIL_PASSWORD=
```


