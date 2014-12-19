<?php

require 'vendor/autoload.php';

use \Router\Router;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Defining Application Name
 */
if (!defined("APP_NAME")) {
	define("APP_NAME","Compras2");
}

/**
 * Booting Eloquent ORM
 */
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

/**
 * Booting TWIG
 */
$loader = new Twig_Loader_Filesystem(__DIR__ . "/Compras2/Assets/Templates");
$twig = new Twig_Environment($loader, array("debug" => true));
$twig->addExtension(new Twig_Extension_Debug());

/**
 * Executing the request
 */
$c = new Router;
$c->get('/brands', APP_NAME ."\\Controllers\\BrandController@index");
$c->get('/brands/new/{name}', APP_NAME . "\\Controllers\\BrandController@add");
$idRule = array('id'=>'numeric');
$c->get('/brands/delete/{id}', APP_NAME . "\\Controllers\\BrandController@delete",$idRule);
$c->get('/brands/{id}/products', APP_NAME . "\\Controllers\\BrandController@listProducts",$idRule);
$c->get('/products', APP_NAME . "\\Controllers\\ProductController@products");
$c->get('/purchases', APP_NAME . "\\Controllers\\PurchaseController@purchases");
$c->execute();
?>