# Fields Composer

Fields Composer is a package intended for use with Sage 10. It provides cached Advanced Custom Fields data to Sage view composers.

## Requirements

[Sage](https://github.com/roots/sage) >= 10.0

[PHP](https://secure.php.net/manual/en/install.php) >= 7.3

[Composer](https://getcomposer.org)

## Installation

Install via composer:

```bash
composer require tinypixel/fields-composer
```

## Usage

In `app/Composers` create a new view composer which extends `TinyPixel\FieldsComposer\FieldsComposer`:

```php
<?php

namespace App\Composers;

use \TinyPixel\FieldsComposer\FieldsComposer;
use \Illuminate\View\View;

class FieldsComposerDemo extends FieldComposer
{
  // ...
}
```

This works exactly like a normal Sage composer but has out of the box support for Advanced Custom Fields and leverages laravel's Cache facade.

You can access fields using `$this->fields()` and set an expiration for the fields cache like so:

```php
  // ...

  /**
   * Expiration time of cache in seconds
   *
   * @var int
   */
  public $cacheExpiry = 3600;

  /**
   * Data to be passed to view before rendering.
   *
   * @param  array $data
   * @param  \Illuminate\View\View $view
   * @return array
   */
  public function with($data, $view)
  {
    return $data = [
      'myFields' => $this->fields(),
      'myGroup' => $this->fields('myGroup'),
      'myItem' => $this->fields('myGroup')->item,
      'mySubItem' => $this->fields('myGroup')->item['subItem'],
    ];
  }

  //...
```

## Configure

By default fields are cached to `storage/framework/cache/data` using the filesystem strategy, but you can change that in `config/cache.php` (if you want to utilize the database, memcached, redis, etc.) This file should have been copied to your project on install.

## Notes

Currently this plugin flushes the entire Laravel Cache when any content is published, edited, deleted, etc. This is true even if the cache is set to 0 in the view composer. This is important to note if you are utilizing the Illuminate Cache elsewhere in your application.
