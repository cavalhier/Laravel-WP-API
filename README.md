# laravel-wp-api



Laravel 5 package for the [Wordpress JSON REST API](https://github.com/WP-API/WP-API)

## Install

Simply add the following line to your `composer.json` and run install/update:

    "Labchain/laravel-wp-api": "~1.0"

## Configuration

You will need to add the service provider and optionally the facade alias to your `config/app.php`:

```php
'providers' => array(
  Labchain\LaravelWpApi\LaravelWpApiServiceProvider::class
)

'aliases' => array(
  'WpApi' => Labchain\LaravelWpApi\Facades\WpApi::class
),
```

And publish the package config files to configure the location of your Wordpress install:

    php artisan vendor:publish

### Usage

The package provides a simplified interface to some of the existing api methods documented [here](http://wp-api.org/).
You can either use the Facade provided or inject the `Labchain\LaravelWpApi\WpApi` class.

#### Posts
```php
WpApi::posts($page);

```

#### Pages
```php
WpApi::pages($page);

```

#### Post
```php
WpApi::post($slug);

```

```php
WpApi::postId($id);

```

#### Categories
```php
WpApi::getCategories();

```

#### Tags
```php
WpApi::tags();

```

#### Category posts
```php
WpApi::getCategories($id);

```

#### Author posts
```php
WpApi::authorPosts($id);

```

#### Tag posts
```php
WpApi::tagPosts($slug, $page);

```

#### Search
```php
WpApi::search($post);

```

#### Archive
```php
WpApi::archive($year, $month, $page);

```
# LabchainWpApi
# LabchainWpApi
# LabchainWpApi
