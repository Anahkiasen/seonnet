<?php
namespace Seonnet;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{

  /**
   * The Seonnet table
   *
   * @var string
   */
  protected $table = 'seonnet';

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// ATTRIBUTES //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get the Route's slug
   *
   * @param string $slug
   *
   * @return string
   */
  public function getSlugAttribute($slug)
  {
    return $slug ?: Str::slug($this->title);
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// REPOSITORY ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Find a Route by its route
   *
   * @param string $route The route
   *
   * @return Route
   */
  public static function findRoute($route)
  {
    return static::where('route', $route)->first();
  }

}