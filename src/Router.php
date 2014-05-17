<?php
namespace Seonnet;

use App;
use Illuminate\Container\Container;

/**
* The Seonnet Router
*/
class Router
{
  /**
   * Build the Seonnet Router
   *
   * @param Container $app
   */
  public function __construct(Container $app)
  {
    $this->app = $app;
  }

  /**
   * Hook into the Router's createRoute
   */
  public function __call($method, $parameters)
  {
    if (in_array($method, array('get'))) {
      $pattern = $parameters[0];
      $action  = $parameters[1];

      return $this->createRoute($method, $pattern, $action);
    }

    return call_user_func_array(array(App::make('router'), $method), $parameters);
  }

  /**
   * Create a route
   */
  protected function createRoute($method, $pattern, $action)
  {
    if (is_callable($action) or is_string($action)) {

      // Get the Route's slug
      $slug = $this->app['seonnet']->getSlug($pattern);
      if (is_callable($action))   $action = array('as' => $pattern, 'do'   => $action);
      elseif (is_string($action)) $action = array('as' => $pattern, 'uses' => $action);

      if ($slug) $pattern = $slug;
    }

    return App::make('router')->$method($pattern, $action);
  }
}
