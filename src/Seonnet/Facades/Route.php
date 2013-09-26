<?php
namespace Seonnet\Facades;

use Illuminate\Support\Facades\Route as RouteFacade;

class Route extends RouteFacade
{
  public static function getFacadeAccessor()
  {
    return 'seonnet.router';
  }
}