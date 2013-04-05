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
    $this->route = $this->getCurrentRoute();
    var_dump($this->tableExists()); exit();
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
    return $this->app['db']->tableExists('seonnet');
  }

  /**
   * Get the current route
   *
   * @return string
   */
  protected function getCurrentRoute()
  {
    return $this->app['request']->path();
  }

}