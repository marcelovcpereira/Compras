<?php

namespace Compras2\Controllers;

class TestController
{
	public function testPost()
	{
		$newProd = array();
		$newProd["name"] = "Biscoito Bono Chocolate 140g";
		$newProd["description"] = "Biscoito recheado sabor chocolate";
		$newProd["brand"] = "13";
		$barcode = "7891000018750";

		$json = json_encode($newProd);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://localhost/projetos/Compras2/api/v1/products/$barcode.json");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close($ch);
		print "RESPONSE:<br>$response<br>." ;
	}

	public function testDelete()
	{
		$barcode = "7891000018750";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://localhost/projetos/Compras2/api/v1/products/$barcode");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close($ch);
		print "RESPONSE:<br>$response<br>." ;
	}

	public function testPut()
	{
		$newProd = array();
		$newProd["name"] = "Biscoito Bono Chocolate 140g";
		$newProd["description"] = "Biscoito recheado sabor chocolate";
		$newProd["brand"] = "13";
		$barcode = "7891000018750";

		$json = json_encode($newProd);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://localhost/projetos/Compras2/api/v1/products/$barcode.json");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close($ch);
		print "RESPONSE:<br>$response<br>." ;
	}
}