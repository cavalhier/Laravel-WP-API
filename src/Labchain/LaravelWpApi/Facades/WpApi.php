<?php namespace Labchain\LaravelWpApi\Facades;

use Illuminate\Support\Facades\Facade;
use Labchain\LaravelWpApi\WpApi as WordpressApi;

class WpApi extends Facade {

    protected static function getFacadeAccessor() { return WordpressApi::class; }

}
