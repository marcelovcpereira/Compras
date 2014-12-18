<?php

namespace Compras2\Controllers;

use Compras2\Models\Product;
use Compras2\Models\Brand;

class ProductController
{
	public function products()
	{
		foreach (Product::with("Brand")->get() as $product) echo $product->name . " - " . $product->id . "(" . $product->brand->name.")<br>";
	}
}