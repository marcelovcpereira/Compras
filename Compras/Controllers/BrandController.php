<?php
namespace Compras\Controllers;

use Illuminate\Database\Eloquent\Model;
use \Compras\Models\Brand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Manage requests related to Brands.
 *
 * @author Marcelo Pereira
 * @since 2015-01-03
 * @package Compras
 * @subpackage Controllers
 */
class BrandController extends Model
{

    public function index()
    {
        foreach (Brand::all() as $b) {
            echo $b->name. "-" . $b->id . "<br>";
        }
    }

    public function add($name)
    {
        $b = new Brand;
        $b->name = $name;
        $b->save();

        echo "A new product was added: $name (id:" . $b->id . ")<br>";
    }

    public function delete($id)
    {
        $b = Brand::find($id);
        if ($b) {
            echo "Deleting brand " . $b->name . "(" . $b->id . ")...<br>";
            $b->delete();

            if (Brand::find($id)) {
                echo "There was an error trying to delete brand ($id)<br>";
            } else {
                echo "Brand $id deleted!<br>";
            }
        } else {
            echo "No Brand found with Id: $id<br>";
        }
    }

    public function listProducts($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            echo "Searching products of " . $brand->name . "<br>";
            foreach ($brand->products as $p) {
                echo $p->name . "<br>";
            }
        } else {
            echo "No brand found with id ($id)<br>";
        }
    }

    /**
     * Adds a Brand via JSON embedded object in a POST request
     *
     */
    public function addJsonBrand()
    {
        $request = Request::createFromGlobals();
        $response = new JsonResponse();
        $content = $request->getContent();
        $errorContent = "";
        try {
            $brand = Brand::createFromJson($content);
            $exists = Brand::where("name", "=", $brand->name)->first();
            if (!$exists) {
                $brand->save();
                $response->setStatusCode(201);
                $response->setContent($brand->jsonify());
                return $response->send();
            } else {
                $errorContent = "Couldn't create brand. Name already exists.";
            }
        } catch (\Exception $e) {
            $errorContent = "Error creating brand: " . $e->getMessage();
        }
        $response->setContent(json_encode(array("error" => $errorContent)));
        $response->setStatusCode(400);
        return $response->send();
    }

    /**
     * Returns all brands JSON-formatted.
     * 
     * @return Response list of brands.
     */
    public function getAllJson()
    {
        $response = new JsonResponse();
        $brands = Brand::orderBy("name")->get(array("name"));
        $response->setContent(json_encode($brands));
        return $response->send();
    }
}
