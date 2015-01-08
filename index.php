<?php

require 'vendor/autoload.php';

use \Router\Router;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Defining Application Name
 */
if (!defined("APP_NAME")) {
    define("APP_NAME", "Compras");
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
$loader = new Twig_Loader_Filesystem(__DIR__ . "/".APP_NAME."/Assets/Templates");
$twig = new Twig_Environment($loader, array("debug" => true));
$twig->addExtension(new Twig_Extension_Debug());

/**
 * Executing the request
 */
$c = new Router;
$c->get('', function() use ($twig) {
    print $twig->render('home.twig.html');
});
$c->get('/brands', APP_NAME ."\\Controllers\\BrandController@index");
$c->get('/brands/new/{name}', APP_NAME . "\\Controllers\\BrandController@add");
$idRule = array('id'=>'numeric');
$c->get('/brands/delete/{id}', APP_NAME . "\\Controllers\\BrandController@delete", $idRule);
$c->get('/brands/{id}/products', APP_NAME . "\\Controllers\\BrandController@listProducts", $idRule);
$c->get('/products', APP_NAME . "\\Controllers\\ProductController@products");
$c->get('/purchases', APP_NAME . "\\Controllers\\PurchaseController@purchases");

/**API METHODS**/

$barcodeRule = array('barcode'=>'numeric');
//Return a JSON product
$c->get('/api/v1/products/{barcode}.json', APP_NAME . "\\Controllers\\ProductController@getJSONProduct", $barcodeRule);
//Insert a JSON product
$c->post('/api/v1/products/json', APP_NAME . "\\Controllers\\ProductController@addJSONProduct");
//Returns all products JSON formatted
$c->get('/api/v1/products/json', APP_NAME . "\\Controllers\\ProductController@getAllJson");
//Delete a product
$c->delete('/api/v1/products/{barcode}', APP_NAME . "\\Controllers\ProductController@deleteProduct", $barcodeRule);
//Updates a product using JSON
$c->put('/api/v1/products/{barcode}.json', APP_NAME . "\\Controllers\ProductController@updateJSONProduct", $barcodeRule);

//BRANDS
//Insert JSON
$c->post('/api/v1/brands/json', APP_NAME . "\\Controllers\\BrandController@addJsonBrand");
//Returns all JSON
$c->get('/api/v1/brands/json', APP_NAME . "\\Controllers\\BrandController@getAllJson");
//Retrieve by ID JSON
$c->get('/api/v1/brands/json/{id}', APP_NAME . "\\Controllers\\BrandController@getJsonBrand", array("id"=>"numeric"));
//Updates a brand
$c->put('/api/v1/brands/json', APP_NAME . "\\Controllers\\BrandController@updateJsonBrand");
//Delete by id JSON
$c->delete('/api/v1/brands/json/{id}', APP_NAME . "\\Controllers\\BrandController@deleteBrand", array("id"=>"numeric"));

/**API METHODS**/

//Testing routes
$c->get('/test/postProduct', APP_NAME . "\\Controllers\\TestController@testPostProduct");
$c->get('/test/putProduct', APP_NAME . "\\Controllers\\TestController@testPut");
$c->get('/test/deleteProduct', APP_NAME . "\\Controllers\\TestController@testDelete");
$c->get('/test/postBrand', APP_NAME . "\\Controllers\\TestController@testPostBrand");

$c->execute();
