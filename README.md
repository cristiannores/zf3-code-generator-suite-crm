 
# zend-code-generator-zf3
Code generator of zf3 fror mappers y classes

This tool generate classes and mappers from database metadata.

## Example 



### How to generate 

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



### How to use mappers 

#### Llamando directamente a los mappers

Se puede llamar directamente a los mappers .. se generara una coneccion diferente si no se le indica el adaptador en el mapper

```php
$mapperContacts = new ContactsMapper();

// Guardando contactos
$mapperContacts->store($data);

// Obteniendo contacto por id
$mapperContacts->get($id);

// Actualizando contacto por id
$mapperContacts->update($contact, $id);

 // Encontrando un contacto por parametros
$mapperContacts->findOneBy($find);

// Encontrando  muchos contactos por parametro
$mapperContacts->findManyBy($data);

// Borrando un contacto 
$mapperContacts->delete($id);

// Obteniendo todos los contactos un contacto 
$mapperContacts->getAll();
```


#### Usando una transaccion para multiples llamadas

Se debe agregar un adaptador para todos los mappers, que instancia a una conexion 

```php
// Get adapter
$database = new Database();
$adapter = $database->getAdapter();        

try {

    // Iniciando transaccion
    $adapter->getDriver()->getConnection()->beginTransaction();

    $mapperContacts = new ContactsMapper($adapter);
    $mapperEmailAddresses = new EmailAddressesMapper($adapter);

    $contact_id = $mapperContacts->store($contacto);
    $email_id = $mapperEmailAddresses->store($email);

    if ($contact_id && $email_id) {
        $asignado = $mapperEmailAddresses->assignToContact($contact_id, $email_id);

        if ($asignado) {

            // Commit
            $adapter->getDriver()->getConnection()->commit();

        } else {

            // rollback
            $adapter->getDriver()->getConnection()->rollback();
        }
    } else {

        // rollback
        $adapter->getDriver()->getConnection()->rollback();

    }        

} catch (Exception $exc) {

    // rollback
    $adapter->getDriver()->getConnection()->rollback();

} catch (\Zend\Db\Adapter\Exception\ErrorException $ex) {

    // rollback
    $adapter->getDriver()->getConnection()->rollback();

} catch (Zend\Db\Adapter\Exception\RuntimeException $ex) {

    // rollback
    $adapter->getDriver()->getConnection()->rollback();           

}
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
