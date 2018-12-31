<?php

namespace mkamel\Searchable\Traits;

use mkamel\Searchable\Exceptions\NotFoundFilterException;

trait Searchable
{
  /**
   * Undocumented function
   *
   * @param [type] $filters
   * @return void
   */
  public static function search($filters)
  {
    $query = self::query();

    foreach ($filters as $key => $value) {
      $filter = (new self)->getFilter($key);
      $query = app()->make($filter)->apply($query, $key, $value);
    }

    return $query;
  }


  /**
   * Undocumented function
   *
   * @param [type] $key
   * @return void
   */
  protected function getFilter($key)
  {
    $filter = $this->getNameSpace() . '\\' . $this->getClassName() . '\\' . $this->getFilterName($key);

    $this->findFilter($filter);

    return $filter;
  }


  /**
   * Undocumented function
   *
   * @return void
   */
  protected function getNameSpace()
  {
    return config('searchable.filters_namespace');
  }


  /**
   * Undocumented function
   *
   * @param [type] $key
   * @return void
   */
  protected function getFilterName($key)
  {
    return config('searchable.prefix') . studly_case($key) . config('searchable.suffix');
  }


  /**
   * Undocumented function
   *
   * @return void
   */
  protected function getClassName()
  {
    $path = explode('\\', __class__);
    return array_pop($path);
  }


  /**
   * Undocumented function
   *
   * @param [type] $filter
   * @return void
   */
  protected function findFilter($filter)
  {
    throw_if(
      ! class_exists($filter),
      NotFoundFilterException::class,
      "$filter not found."
    );

    return true;
  }
}
