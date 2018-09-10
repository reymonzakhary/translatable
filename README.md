# Laravel Translatable Packages

## Installation

To install through composer, simply put the following in your composer.json file:

```
{
    "require": {
        "upon/translatable": "~1.0.0"
    }
}

```
And then run composer install from the terminal.

## Quick Installation

Above installation can also be simplify by using the following command:
```
composer require upon/translatable
```
In Laravel 5.5, the service provider and facade will automatically get registered. For older versions of the framework, follow the steps below:

Register the service provider in config/app.php

```
'providers' => [
		// [...]
                Upon\Translatable\Providers\TranslatableServiceProvider::class,
        ],
```
## Usage

Run migration to migrate the translation table

```
    php artisan migrate
```

Add the trait to your model

```
use Upon\Translatable\Traits\TranslatableTrait;

class Model
{
    use TranslatableTrait;

    protected $translatable = ['name'];

```
## Example 
Set your local and start using the translation 

```
    App::setLocale('nl');

    return Model::create([
        'name' => 'your name ', // this will be used as fallback for translation if not translated yet
    ]);

```

the trait will automatically create a translation for this column









