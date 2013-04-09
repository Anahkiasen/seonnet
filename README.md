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
  'title'   => 'Our agency',
  'meta'    => array(
    'description' => 'Interesting stuff about your agency'
  ),
  'url'     => '',
  'lang'    => 'fr',
]);
```

From there you registered a page. You now need to plug Seonnet into various places, first being your routes :

```php
Route::get(Seonnet::slug('agency'), function() {
  return View::make('agency');
});
```

From there, you will be able to access this page via both `agency` and `our-agency` (an automatic slug created from the `title` attribute of your Route model).