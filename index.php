<?php

require 'vendor/autoload.php';

use \Router\Router;
use Illuminate\Database\Capsule\Manager as Capsule;


$cap = new Capsule;
$cap->addConnection(array(
	'driver' => 'mysql',
	'host' => 'localhost',
	'database' => 'compras',
	'username' => 'root',
	'password' => "",
	'charset' => 'utf8',
	'collation' => 'utf8_general_ci'
));
$cap->bootEloquent();

$idRule = array('id'=>'numeric');

$c = new Router;
$c->get('/brands','\Compras2\Controllers\BrandController@index');
$c->get('/brands/new/{name}','\Compras2\Controllers\BrandController@add');
$c->get('/brands/delete/{id}','\Compras2\Controllers\BrandController@delete',$idRule);
$c->get('/brands/{id}/products','\Compras2\Controllers\BrandController@listProducts',$idRule);
$c->get('/products','\Compras2\Controllers\ProductController@products');
$c->execute();
?>