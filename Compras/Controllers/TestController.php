<?php

namespace Compras\Controllers;

/**
 * Tests the behavior of the API.
 *
 * @author Marcelo Pereira
 * @since 2015-01-03
 * @package Compras
 * @subpackage Controllers
 */
class TestController
{
    /**
     * Tests the addition of a new Product.
     *
     * @return void
     */
    public function testPostBrand()
    {
        $newBrand = array();
        $newBrand["name"] = "Qualitá";
        $json = json_encode($newBrand);
        $url = "http://localhost/projetos/Compras2/api/v1/brands/json";
        $method = "POST";
        $response  = $this->executeJsonCurl($url, $method, $json);
        print "RESPONSE:<br>$response<br>." ;
    }

    /**
     * Executes a Curl request.
     *
     * @param  string $url    Target url.
     * @param  string $method HTTP method of request.
     * @param  string $data   Payload of request.
     * @return string         Response of request.
     */
    public function executeJsonCurl($url, $method, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * Tests the addition of a new Product.
     *
     * @return void
     */
    public function testPostProduct()
    {
        $newProd = array();
        $newProd["name"] = "Atum sólido ao Natural";
        $newProd["description"] = "Atum enlatado sólido - peso 170g";
        $newProd["brand"] = "6";
        $newProd["barcode"] = "7891167012066";

        $json = json_encode($newProd);
        $url = "http://localhost/projetos/Compras2/api/v1/products/json";
        $method = "POST";

        $response  = $this->executeJsonCurl($url, $method, $json);
        print "RESPONSE:<br>$response<br>." ;
    }

    /**
     * Tests the deletion of a product.
     *
     * @return void
     */
    public function testDelete()
    {
        $barcode = "7891000018750";
        $url = "http://localhost/projetos/Compras2/api/v1/products/$barcode";
        $method = "DELETE";
        $response  = $this->executeJsonCurl($url, $method, null);
        print "RESPONSE:<br>$response<br>." ;
    }

    /**
     * Tests updating a Product.
     *
     * @return void
     */
    public function testPut()
    {
        $newProd = array();
        $newProd["name"] = "Biscoito Bono Chocolate 140g";
        $newProd["description"] = "Biscoito recheado sabor chocolate";
        $newProd["brand"] = "13";
        $barcode = "7891000018750";
        $url = "http://localhost/projetos/Compras2/api/v1/products/$barcode.json";
        $method = "PUT";
        $json = json_encode($newProd);
        $response  = $this->executeJsonCurl($url, $method, $json);
        print "RESPONSE:<br>$response<br>." ;
    }
}
