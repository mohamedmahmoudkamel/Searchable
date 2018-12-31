<?php

namespace Searchable;

use Illuminate\Support\ServiceProvider;

class SearchableServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->publishes([
      __DIR__ . '/searchable.php' => config_path('searchable.php'),
    ]);
  }

  public function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/searchable.php',
      'searchable'
    );
  }
}
