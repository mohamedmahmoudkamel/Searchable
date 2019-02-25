# Searchable

1- Add this line to your `app.php` file in `providers` array:
```php
MKamel\Searchable\SearchableServiceProvider::class,
```

2- Use `Searchable` Trait in your Model.

3- That will make `Search` function available for you model
```php
User::search([
  'name' => 'alex',
  'older_than' => 20
]);
```

4- Create your Filters:
```php
class ByOlderThanFilter
{
  public function apply($query, $key, $value)
  {
    return $query
      ->where('age', '>=', $value)
  }
}
```

5- You can update the filters directory by changing `filters_namespace` in config file.
