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
   * A cache of the matched routes
   *
   * @var array
   */
  protected $matchedRoutes = array();

  /**
   * Build a new Seonnet instance
   *
   * @param Container $app
   */
  public function __construct(Container $app)
  {
    $this->app = $app;
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
  public function slug($url)
  {
    return $route = $this->getRoute($url) ? $route->slug : $url;
  }

  /**
   * Get the page's title
   *
   * @param string $fallback A fallback title
   *
   * @return string
   */
  public function getTitle($fallback = null)
  {
    $route = $this->getCurrentRoute();
    if(!$route) return $fallback;

    return $route->title;
  }

  /**
   * Get the current page's meta tags
   *
   * @return string
   */
  public function getMeta($route = null)
  {
    if (!$route) $route = $this->getCurrentUrl();
    $route = $this->getRoute($route);
    if (!$route) return;

    return $route->metaTags;
  }

  ////////////////////////////////////////////////////////////////////
  //////////////////////////////// ROUTES ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get a Route by it's URL/slug
   *
   * @param string $route
   *
   * @return Route
   */
  public function getRoute($url)
  {
    if (!$this->tableExists()) return;

    // Return Route in cache if any
    if (isset($this->matchedRoutes[$url])) {
      return $this->matchedRoutes[$url];
    }

    $routes = Route::all();

    // Search for a Route whose pattern matches the current URL
    foreach ($routes as $route) {
      if (preg_match($route->route, $url) or $url == Str::slug($route->slug)) {
        $this->matchedRoutes[$url] = $route;

        return $route;
      }
    }
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
    $route = $this->getCurrentUrl();

    return $this->getRoute($route);
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

}