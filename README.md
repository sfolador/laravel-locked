# Locked eloquent models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfolador/laravel-locked.svg?style=flat-square)](https://packagist.org/packages/sfolador/laravel-locked)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/sfolador/laravel-locked/run-tests?label=tests)](https://github.com/sfolador/laravel-locked/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/sfolador/laravel-locked/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/sfolador/laravel-locked/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sfolador/laravel-locked.svg?style=flat-square)](https://packagist.org/packages/sfolador/laravel-locked)

A package to add locking features to Eloquent Models.

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


## Command

There is an artisan command to create a migration for a class, run the command with :

```bash
php artisan lock-add {classname}
```

For example, if you want to add a locking column to the `User` model, you can run the command :

```bash
php artisan lock-add User
```

This will create a migration file in the `database/migrations` folder, you can then run the migration with :

```bash
php artisan migrate
```

## Usage

Once created the migration, you can use the `Lockable` trait in your model.

```php
use Sfolador\Locked\Traits\HasLocks;

class User extends Model
{
    use HasLocks;
}
```

this trait will add the following methods to your model :

- `lock()` : adds a lock to the model by setting the locking column to the current date
- `unlock()`: removes the lock by setting the locking column to null
- `isLocked()`: returns true if the model is locked, false otherwise
- `isUnlocked()`: returns true if the model is unlocked, false otherwise
- `isNotUnlocked()`: returns true if the model is not unlocked, false otherwise
- `isNotLocked()`: returns true if the model is not locked, false otherwise
- `toggleLock()`: toggles the lock state of the model


## Example

```php
$user = User::find(1);
$user->lock();

//...

if ($user->isNotLocked()) {
   UserManager::update($user);
}
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Credits
- [sfolador](https://github.com/sfolador)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
