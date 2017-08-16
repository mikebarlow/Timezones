# Timezones

[![Author](http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square)](https://twitter.com/mikebarlow)
[![Latest Version](https://img.shields.io/github/release/mikebarlow/Timezones.svg?style=flat-square)](https://github.com/mikebarlow/Timezones/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/mikebarlow/Timezones/blob/master/LICENSE)
[![Build Status](https://img.shields.io/travis/mikebarlow/Timezones/master.svg?style=flat-square)](https://travis-ci.org/mikebarlow/Timezones)

## Introduction

Timezones is a PSR-2 compliant package used for easily converting dates into UTC or into your local timezones. Bundled is also support for Laravel Facades and blade directives to make usage even easier!

## Requirements

### Composer

Timezones has no dependencies or requires for standard usage.

And the following if you wish to run in dev mode and run tests.

* "phpunit/phpunit": "~5.7"
* "squizlabs/php_codesniffer": "~2.0"

## Installation

### Composer

Simplest installation is via composer.

    composer require snscripts/timezones 1.*

or adding to your projects `composer.json` file.

    {
        "require": {
            "snscripts/timezones": "1.*"
        }
    }

### Setup

To get started simply instantiate the Timezones object with the `new` keyword in PHP.

    $Timezones = new \Snscripts\Timezones\Timezones;

Timezones requires no outside dependencies.

## Usage

To use, first instantiate the object as described above. Once that has been done you can use one of two methods.

### convertToUTC

    $Timezones->convertToUTC($DateTime, $Timezone, $format);

This method should be used when parsing an user inputted date to convert it to UTC ready for storing in your database.

`$DateTime`is a required field and  can either be an instance of `\DateTime` that was created with the correct local timezone or it can be a string which will be passed into an instance of `\DateTime`.

If `$DateTime` is an instance of `\DateTime` then `$Timezone` is not required and should default to `null`. If `$DateTime` is passed through as a string then `$Timezone` should either be an instance of `\DateTimeZone` or a string describing a [valid timezone](http://php.net/manual/en/timezones.php).

`$format` is an optional field that defaults to standard MySQL datetime format of `YYYY-MM-DD HH:MM:SS`.

### convertToLocal

    $Timezones->convertToLocal($DateTime, $Timezone, $format);

This method should be used in your "views" to transform a UTC date stored within your database into the local timezone for the user viewing the page.

`$DateTime` is a required field and can either be an instance of `\DateTime` that was created with the correct UTC timezone or it can be a string which will be passed into an instance of `\DateTime`.

`$Timezone` is a required field and can either be an instance of `\DateTimeZone` or a string describing a [valid timezone](http://php.net/manual/en/timezones.php).

`$format` is an optional field that defaults to standard MySQL datetime format of `YYYY-MM-DD HH:MM:SS`.

## Laravel Integration

Bundled with this package is a Laravel Service provider that is setup for auto-discovery ready for 5.5.

If you are not using Laravel 5.5 then you can add the following Service Provider to add the Timezone integration to Laravel.

    \Snscripts\Timezones\TimezonesServiceProvider::class

### Container

The Service Provider binds the Timezones class to the container meaning you can easily typehint the Timezone object into your classes using the following typehint `\Snscripts\Timezones\Timezones`.

### Facade

Should you prefer to use a Facade, one has been bundled and made available with the Service Provider. The facade is available at `\Timezones'.

Both methods described in the "Usage" section above are available.

    \Timezones::convertToUTC();
    \Timezones::convertToLocal();

### Blade Directive

A blade directive will also be registered by the Service Provider. This only supports the `convertToLocal` method and is designed for use within your blade templates to display the correct date.

    @displayDate($DateTime, $Timezone, $format)

All parameters match those defined for the `convertToLocal` method however all fields are required when using the blade directive.


## Testing

If you wish to run the unit tests, simply install composer on the package with dev dependencies.

    composer install --dev

Then run PHPUnit with the following command from the root of the Timezones package folder.

    ./vendor/bin/phpunit

## Changelog

You can view the changelog [HERE](https://github.com/mikebarlow/Timezones/blob/master/CHANGELOG.md)

## Contributing

Please see [CONTRIBUTING](https://github.com/mikebarlow/Timezones/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/mikebarlow/Timezones/blob/master/LICENSE) for more information.
