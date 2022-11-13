# This package adds locking features to Eloquent Models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfolador/laravel-locked.svg?style=flat-square)](https://packagist.org/packages/sfolador/laravel-locked)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/sfolador/laravel-locked/run-tests?label=tests)](https://github.com/sfolador/laravel-locked/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/sfolador/laravel-locked/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/sfolador/laravel-locked/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sfolador/laravel-locked.svg?style=flat-square)](https://packagist.org/packages/sfolador/laravel-locked)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-locked.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-locked)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require sfolador/laravel-locked
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-locked-config"
```

This is the contents of the published config file:

```php
return [
   'locking_column' => 'locked_at'
];
```

You can choose another default column name for the locking column by changing the `locking_column` value.


## Usage

```php
$locked = new Sfolador\Locked();
echo $locked->echoPhrase('Hello, Sfolador!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [sfolador](https://github.com/sfolador)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
