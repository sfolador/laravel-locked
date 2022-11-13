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
   'locking_column' => 'locked_at',
   
    'default_namespace' => 'App\Models',

    'unlock_allowed' => true,
    'can_be_unlocked' => [
    ],
];
```

You can choose another default column name for the locking column by changing the `locking_column` value.
The `default_namespace` value is used to automatically add the namespace to the model passed as an argument to the Command. See the Usage section for more details.

The `unlock_allowed` value is used to enable or disable the `unlock` command. If you set it to `false`, the `unlock` method will raise an exception. 
It's possible to add a _whitelist_ of models that can be unlocked by setting the `can_be_unlocked` array. 
If the array is empty and the `unlock_allowed` value is `false`, no model can be unlocked.


## Command

There is an artisan command to create a migration for a class, run the command with :

```bash
php artisan lock-add {classname} {--namespace=}
```

For example, if you want to add a locking column to the `User` model, you can run the command :

```bash
php artisan lock-add User
```

This will create a migration file in the `database/migrations` folder, you can then run the migration with :

```bash
php artisan migrate
```

The command accepts an optional `--namespace` parameter, to specify the namespace of the class, for example :

```bash
php artisan lock-add User --namespace=App\Models\SomeFolder
```

The default namespace for the command is `App\Models` but you can change it in the config file by modifying the `default_namespace` value.




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

## Todo

- [x] Add an option to forbid locking a model if it is already locked and raise an Exception
- [ ] Add an option to assign the locking/unlocking of a model to a specific type of user
- [ ] Add logging to locking/unlocking actions for auditing purposes

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
