# Timezones

[![Author](http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square)](https://twitter.com/mikebarlow)
[![Latest Version](https://img.shields.io/github/release/mikebarlow/Timezones.svg?style=flat-square)](https://github.com/mikebarlow/Timezones/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/mikebarlow/Timezones/blob/master/LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/mikebarlow/Timezones/PHP%20Composer?style=flat-square)](https://github.com/mikebarlow/Timezones/actions)

## Introduction

Timezones is a PSR-2 compliant package used for easily converting dates into UTC or into your local timezones. Bundled is also support for Laravel Facades and blade directives to make usage even easier!

## Installation

### Composer

Simply require the package via composer into your app.

    composer require mbarlow/timezones 2.*

### Setup

To get started simply instantiate the Timezones object with the `new` keyword in PHP.

```php
    $timezones = new \MBarlow\Timezones\Timezones;
```

#### Laravel

Bundled with this package is a Laravel Service provider that is setup for auto-discovery.

If you are not using Laravel 5.5 then you can add the following Service Provider to your `config/app.php` config.

```php
[
    /*
     * Package Service Providers...
     */    
    \MBarlow\Timezones\TimezonesServiceProvider::class,
];
```

The service provider will bind the Timezones Object to the container allowing you to type hint in the object.

```php
use MBarlow\Timezones\Timezones;
class MyController 
{
    public function myControllerAction(Timezones $timezones)                
    {
        // 
    }
}
```

## Usage

To use, first instantiate the object or typehint the object into your method.

### convertToUTC

```php
    $timezones = new \MBarlow\Timezones\Timezones;

    $dateTime = '2020-08-14 12:23:00';
    $tz = 'America/New_York';
    $format = 'Y-m-d H:i:s';

    $timezones->convertToUTC($dateTime, $tz, $format);
```

```php
use MBarlow\Timezones\Timezones;
class MyController 
{
    public function myControllerAction(Timezones $timezones)                
    {
        $dateTime = '2020-08-14 12:23:00';
        $tz = 'America/New_York';
        $format = 'Y-m-d H:i:s';
    
        $timezones->convertToUTC($dateTime, $tz, $format);
    }
}
```

This method should be used when parsing an user inputted date to convert it to UTC ready for storing in your database.

`$dateTime`is a required field and can either be an instance of `\DateTime` that was created with the correct local timezone or it can be a string which will be passed into an instance of `\DateTime`.

If `$dateTime` is an instance of `\DateTime` then `$tz` is not required and should default to `null`. If `$dateTime` is passed through as a string then `$tz` should either be an instance of `\DateTimeZone` or a string describing a [valid timezone](http://php.net/manual/en/timezones.php).

`$format` is an optional field that defaults to standard MySQL datetime format of `YYYY-MM-DD HH:MM:SS`.

### convertToLocal

```php
    $timezones = new \MBarlow\Timezones\Timezones;

    $dateTime = '2020-08-14 12:23:00';
    $tz = 'America/New_York';
    $format = 'jS F Y H:i';

    $timezones->convertToLocal($dateTime, $tz, $format);
```

```php
use MBarlow\Timezones\Timezones;
class MyController 
{
    public function myControllerAction(Timezones $timezones)                
    {
        $dateTime = '2020-08-14 12:23:00';
        $tz = 'America/New_York';
        $format = 'jS F Y H:i';
    
        $timezones->convertToLocal($dateTime, $tz, $format);
    }
}
```

This method should be used in your "views or in your API endpoints" to transform a UTC date stored within your database into the local timezone for the user viewing the page or requesting the data.

`$dateTime` is a required field and can either be an instance of `\DateTime` that was created with the correct UTC timezone or it can be a string which will be passed into an instance of `\DateTime`.

`$tz` is a required field and can either be an instance of `\DateTimeZone` or a string describing a [valid timezone](http://php.net/manual/en/timezones.php) and should be the timezone of the end user.

`$format` is an optional field that defaults to standard MySQL datetime format of `YYYY-MM-DD HH:MM:SS`.

## Laravel Extras

If you have installed the package into a Laravel application a few extra goodies are available.

### Facade

Should you prefer to use a Facade, one has been bundled and made available with the Service Provider. The facade is available at `\Timezones'.

Both methods described in the "Usage" section above are available.

    \Timezones::convertToUTC();
    \Timezones::convertToLocal();

### Blade Directive

A blade directive will also be registered by the Service Provider. This only supports the `convertToLocal` method and is designed for use within your blade templates to convert a UTC datetime into the end users time and display on the page in the correct format.

    @displayDate($dateTime, $tz, $format)

All parameters match those defined for the `convertToLocal` method however all fields are required when using the blade directive.

## Testing

If you wish to run the tests, clone out the repository

```bash
    git clone git@github.com:mikebarlow/Timezones.git
```

Change to the root of the repository and run composer install with the dev dependencies

```bash
    cd Timezones
    composer install
```

A script is defined in the `composer.json` to run both the code sniffer and the unit tests

```bash 
    composer run test
```

Or run them individually as required

```bash
    ./vendor/bin/phpunit
    
    ./vendor/bin/phpcs --standard=PSR2 --ignore=src/Facade/* src
```

## Changelog

You can view the changelog [HERE](https://github.com/mikebarlow/Timezones/blob/master/CHANGELOG.md)

## Contributing

Please see [CONTRIBUTING](https://github.com/mikebarlow/Timezones/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/mikebarlow/Timezones/blob/master/LICENSE) for more information.
