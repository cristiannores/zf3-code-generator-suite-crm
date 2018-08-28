# zend-code-generator-zf3
Code generator of zf3 fror mappers y classes

This tool generate classes and mappers from database metadata.

## Example 



## HOW TO USE 

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

### modify core/config.php


```php
$GLOBALS['suite_crm_path'] = '/var/www/suite/public_html';       
```


### Run code generator

```bash
php generate.php
```

### Method run 

Método para correr el generador

```bash
php generate.php run 
```

#### Option --table -t

Agregar el nombre de la tabla que se desea generar

```bash
php generate.php run --table my_table_name 
```
#### Option --override

Sobre escribir el mapper existente

```bash
php generate.php run --table my_table_name  --override
```

#### Option --all

Genera todos los mappers y classes de la base de datos

```bash
php generate.php run --all
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
