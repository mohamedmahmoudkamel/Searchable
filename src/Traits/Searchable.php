<?php

namespace MKamel\Searchable\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use MKamel\Searchable\Exceptions\NotFoundFilterException;

trait Searchable
{
    /**
     * @param $filters
     * @return Builder
     */
  public static function search($filters)
  {
    $query = self::query();

    foreach ($filters as $key => $value) {
      if(is_null($value)) continue;

      $filter = (new self)->getFilter($key);

      $query = app()->make($filter)->apply($query, $key, $value);
    }

    return $query;
  }


    /**
     * @param string $key
     * @return string
     */
    protected function getFilter($key)
  {
    $filter = $this->getNameSpace() . '\\' . $this->getClassName() . '\\' . $this->getFilterName($key);

    $this->checkIfFilterExists($filter);

    return $filter;
  }


    /**
     * @return string
     */
    protected function getNameSpace()
  {
    return config('searchable.filters_namespace');
  }


    /**
     * @param string $key
     * @return string
     */
    protected function getFilterName($key)
  {
    return config('searchable.prefix') . Str::studly($key) . config('searchable.suffix');
  }


    /**
     * @return string
     */
    protected function getClassName()
  {
    $path = explode('\\', __class__);
    return array_pop($path);
  }


    /**
     * @param string $filterFullPath
     * @throws NotFoundFilterException
     */
    protected function checkIfFilterExists($filterFullPath)
  {
    throw_if(
      ! class_exists($filterFullPath),
      NotFoundFilterException::class,
      "$filterFullPath not found."
    );
  }
}
