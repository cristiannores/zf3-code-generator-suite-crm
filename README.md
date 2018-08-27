# zend-code-generator-zf3
Code generator of zf3 fror mappers y classes

This tool generate classes and mappers from database metadata.

## Example 


### modify core/Database.php
```php
if (!$driver) {
  $this->adapter = new Zend\Db\Adapter\Adapter([
    'driver' => 'Pdo',
    'dsn'    => 'mysql:dbname=test;host=localhost;charset=utf8',
    'username' => 'root',
    'password' => '', 
    'options' => array(
    'buffer_results' => true,
  )]);
}            
```

### Run code generator
```
php generate.php
```

Thats All!! 
THXS...

## Version

VERSION 1.0

## Authors

* **Cristian Nores** - *ZF3* - [Cristian Nores](https://github.com/cristiannores)

See also the list of [contributors](https://github.com/cristiannores/zend-code-generator-zf3/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
