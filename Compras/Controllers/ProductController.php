<?php

namespace Compras2\Controllers;

use Compras2\Models\Product;
use Compras2\Models\Brand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProductController
{
    public function products()
    {
        foreach (Product::with("Brand")->get() as $product) {
            echo $product->name . " - " . $product->id . "(" . $product->brand->name.")<br>";
        }
    }

    public function getJSONProduct($barcode)
    {
        $product = Product::find($barcode);
        $response = new JsonResponse();
        if ($product) {
            $response->setContent($product->jsonify());
        } else {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array("error"=>"Product not found.")));
        }
        $response->send();
    }

    public function addJSONProduct($barcode)
    {
        $request = Request::createFromGlobals();
        $response = new JsonResponse();
        //Generic Error message
        $errorContent = json_encode(array("error"=>"No Json Content delivered."));
        //If the request has a json body
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $content = $request->getContent();
            if ($content) {
                $exists = Product::where("barcode", "=", "$barcode")->first();
                if (!$exists) {
                    $product = Product::createFromJson($content);
                    if ($product) {
                        $product->save();
                        $response->setStatusCode(201);
                        $response->setContent($product->jsonify());
                        return $response->send();
                    } else {
                        $errorContent = json_encode(array("error"=>"Invalid product format."));
                    }
                } else {
                    $errorContent = json_encode(array("error"=>"Couldn't create product. Barcode already exists."));
                }
            }
        }
        $response->setContent($errorContent);
        $response->setStatusCode(400);
        return $response->send();
    }

    public function updateJSONProduct($barcode)
    {
        $request = Request::createFromGlobals();
        $response = new JsonResponse();
        //Generic Error message
        $errorContent = json_encode(array("error"=>"No Json Content delivered."));
        
        //If the request has a json body
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $content = $request->getContent();
            if ($content) {
                $exists = Product::where("barcode", "=", "$barcode")->first();
                if ($exists) {
                    $exists->updateFromJson($content);
                    if ($exists) {
                        $exists->save();
                        $response->setStatusCode(200);
                        $response->setContent($exists->jsonify());
                        return $response->send();
                    } else {
                        $errorContent = json_encode(array("error"=>"Invalid product format."));
                    }
                } else {
                    $errorContent = json_encode(array("error"=>"Couldn't update product. Barcode doesn't exist."));
                }
            }
        }
        $response->setContent($errorContent);
        $response->setStatusCode(400);
        return $response->send();
    }

    public function deleteProduct($barcode)
    {
        $product = Product::where("barcode", "=", "$barcode");
        $response = new Response();
        if ($product) {
            $product->delete();
            $response->setContent("Product with barcode ($barcode) successfully deleted.");
        } else {
            $response->setStatusCode(404);
            $response->setContent("Error: Product with barcode ($barcode) not found.");
        }
        return $response->send();
    }
}
