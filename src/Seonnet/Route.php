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
  public function getSlugAttribute()
  {
    $slug = $this->url ?: $this->title;

    return Str::slug($slug);
  }

  /**
   * Get the meta tags as an array
   *
   * @param string $meta
   *
   * @return array
   */
  public function getMetaAttribute($meta)
  {
    return json_decode($meta, true);
  }

  /**
   * Get the meta tags as HTML tags
   *
   * @return string
   */
  public function getMetaTagsAttribute()
  {
    $tags = $this->meta;
    if (!$tags) return;

    // Format tags
    foreach ($tags as $name => &$tag) {
      $tag = '<meta name="' .$name. '" content="' .$tag. '">';
    }

    return implode($tags);
  }

  /**
   * Set the Route's meta tags
   *
   * @param array $meta
   */
  public function setMetaAttribute($meta)
  {
    $this->attributes['meta'] = json_encode($meta);
  }

}