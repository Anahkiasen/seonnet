# Seonnet

A SEO handler for Laravel, to manage localized slugs, meta tags, etc.

## How it works

### Setting up

You start by creating the Seonnet table by typing `artisan seonnet:table` and running `artisan migrate`. From there a table is created following this schema (here with a few example entries) :

    | pattern   | title   | meta        | url    | lang   |
    | --------- | ------- | ------      | -----  | ------ |
    | string    | string  | text (json) | string | string |

You can add entries to this table by using the provided `seonnet/admin` route (not yet implemented) or via the `Seonnet\Route` model :

```php
Seonnet\Route::insert([
  'pattern' => 'agency/*',
  'title'   => 'Welcome to our agency',
  'meta'    => array(
    'description' => 'Interesting stuff about your agency'
  ),
  'url'     => '',
  'lang'    => 'fr',
]);
```

To use Sonnet after that you'll need to replace Laravel's Router with Seonnet's by adding this line to your aliases array in `config/app.php` :

```php
'Route' => 'Seonnet\Facades\Route',
```

The magic will happen when you type this :

```php
Route::get('agency', function() {
  return View::make('agency');
});
```

