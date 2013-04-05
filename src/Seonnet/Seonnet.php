<?php
namespace Seonnet;

use Illuminate\Container\Container;

class Seonnet
{

  /**
   * The IoC Container
   *
   * @var Container
   */
  protected $app;

  /**
   * Build a new Seonnet instance
   *
   * @param Container $app
   */
  public function __construct(Container $app)
  {
    $this->app   = $app;
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// CORE METHODS /////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Returns the slug for an URL
   *
   * @param string $url The URL
   *
   * @return string The slug
   */
  public static function slug($url)
  {
    $route = Route::findRoute($url);

    return $route->slug ?: $url;
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// HELPERS ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Check if the Seonnet table exists
   *
   * @return boolean
   */
  protected function tableExists()
  {
    $schemaBuilder = $this->app['db']->connection()->getSchemaBuilder();

    return $schemaBuilder->hasTable('seonnet');
  }

  /**
   * Get the current URL
   *
   * @return string
   */
  protected function getCurrentUrl()
  {
    return $this->app['request']->path();
  }

  /**
   * Get the current Route
   *
   * @return Route
   */
  protected function getCurrentRoute()
  {
    return Route::findRoute($this->getCurrentUrl());
  }

}