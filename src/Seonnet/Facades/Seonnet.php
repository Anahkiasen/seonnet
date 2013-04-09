<?php
namespace Seonnet\Facades;

use Illuminate\Support\Facades\Facade;

class Seonnet extends Facade
{

  public static function getFacadeAccessor()
  {
    return 'seonnet';
  }

}