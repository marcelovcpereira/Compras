<?php
namespace Compras\Controllers;

use Illuminate\Database\Eloquent\Model;
use \Compras\Models\Brand;

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
}
