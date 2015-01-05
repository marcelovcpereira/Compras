<?php

namespace Compras\Controllers;

use Compras\Models\Product;
use Compras\Models\Brand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Manages requests related to products.
 *
 * @author Marcelo Pereira
 * @since 2015-01-03
 * @package Compras
 * @subpackage Controllers
 */
class ProductController
{
    const INVALID_CONTENT_EXCEPTION_MESSAGE = "No Json or invalid Content delivered.";

    public function products()
    {
        foreach (Product::with("Brand")->get() as $product) {
            echo $product->name . " - " . $product->id . "(" . $product->brand->name.")<br>";
        }
    }

    /**
     * Returns a JSON formatted product by barcode
     *
     * @param  string(13) $barcode Barcode of requested product
     * @return string(json) JSON format of the requested product
     */
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

    /**
     * Returns all products JSON-formatted.
     * 
     * @return Response list of products.
     */
    public function getAllJson()
    {
        $response = new JsonResponse();
        $products = Product::orderBy("name")->get(array("name","description","barcode"));
        $response->setContent(json_encode($products));
        return $response->send();
    }

    /**
     * Adds a Product via JSON embedded object in a POST request
     *
     */
    public function addJSONProduct()
    {
        $request = Request::createFromGlobals();
        $response = new JsonResponse();
        $content = $request->getContent();
        //If there is content payload
        if ($content) {
            try {
                $product = Product::createFromJson($content);
                $exists = Product::where("barcode", "=", $product->barcode)->first();
                if (!$exists) {
                    $product->save();
                    $response->setStatusCode(201);
                    $response->setContent($product->jsonify());
                    return $response->send();
                } else {
                    $errorContent = "Couldn't create product. Barcode already exists.";
                }
            } catch (\Exception $e) {
                $errorContent = "Error creating product: " . $e->getMessage();
            }
        } else {
            $errorContent = self::INVALID_CONTENT_EXCEPTION_MESSAGE;
        }
        $response->setContent(json_encode(array("error" => $errorContent)));
        $response->setStatusCode(400);
        return $response->send();
    }

    /**
     * Updates an existing product via a JSON embedded POST request.
     *
     * @param  string(13) $barcode   Barcode of the product to be changed.
     * @return string(json)          Updated product.
     */
    public function updateJSONProduct($barcode)
    {
        $request = Request::createFromGlobals();
        $response = new JsonResponse();
        $content = $request->getContent();
        if ($content) {
            $exists = Product::where("barcode", "=", "$barcode")->first();
            if ($exists) {
                try {
                    $exists->updateFromJson($content);
                    $exists->save();
                    $response->setStatusCode(200);
                    $response->setContent($exists->jsonify());
                    return $response->send();
                } catch (\Exception $e) {
                    $errorContent = "Could not update product: " . $e->getMessage();
                }
            } else {
                $errorContent = "Couldn't update product. Barcode doesn't exist.";
            }
        } else {
            $errorContent = self::INVALID_CONTENT_EXCEPTION_MESSAGE;
        }

        $response->setContent(json_encode(array("error" => $errorContent)));
        $response->setStatusCode(400);
        return $response->send();
    }

    /**
     * Deletes a product by barcode.
     *
     * @param  string(13) $barcode Barcode of the product to be deleted.
     * @return string          Status message of the operation.
     */
    public function deleteProduct($barcode)
    {
        $product = Product::where("barcode", "=", "$barcode");
        $response = new Response();
        $errorContent = "";

        if ($product) {
            $product->delete();
            $errorContent = "Product with barcode ($barcode) successfully deleted.";
        } else {
            $response->setStatusCode(404);
            $errorContent = "Error: Product with barcode ($barcode) not found.";
        }
        $response->setContent(json_encode(array("error" => $errorContent)));
        return $response->send();
    }
}
