<?php
namespace Seonnet;

use App;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\Routing\Router as IlluminateRouter;

class Seonnet
{

  /**
   * The IoC Container
   *
   * @var Container
   */
  protected $app;

  /**
   * The Router
   *
   * @var Router
   */
  protected $router;

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
  public function __construct(Container $app, IlluminateRouter $router)
  {
    $this->app    = $app;
    $this->router = $router;
  }

  public function getRouter()
  {
    return $this->router;
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
  public function getSlug($url)
  {
    $route = $this->getRoute($url);
    $slug  = $route ? $route->slug : $url;

    return $slug;
  }

  /**
   * Get the page's title
   *
   * @param string $fallback A fallback title
   *
   * @return string
   */
  public function title($fallback = null)
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
  public function meta($route = null)
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
      if (preg_match($route->pattern, $url) or
          $url == $route->slug or
          $url == $route->name) {
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