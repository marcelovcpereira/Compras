<?php
namespace Compras2\Models;

class Product extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "product";
    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo("\Compras2\Models\Brand");
    }

    public function jsonify()
    {
        $attributes = array();
        $attributes["name"] = $this->name;
        $attributes["description"] = $this->description;
        $attributes["brand"] = $this->brand->name;
        $attributes["id"] = $this->id;
        $attributes["barcode"] = $this->barcode;

        return json_encode($attributes);
    }

    public static function createFromJson($json)
    {
        $obj = json_decode($json);
        if ($obj && self::isValidObject($obj)) {
            $product = new Product();
            $product->name = $obj->name;
            $product->description = $obj->description;
            $product->brand_id = $obj->brand;
            $product->barcode = $barcode;
            return $product;
        }
        return null;
    }

    public function updateFromJson($json)
    {
        $obj = json_decode($json);
        if ($obj && self::isValidObject($obj, false)) {
            $this->name = $obj->name;
            $this->description = $obj->description;
            $this->brand_id = $obj->brand;
            return;
        }
        throw new \Exception("Bad format exception");
    }

    public static function isValidObject($obj, $checkBarcode = true)
    {
        if (!property_exists($obj, "name")) {
            throw new \Exception("invalid name");
            return false;
        }

        if (!property_exists($obj, "description")) {
            throw new \Exception("invalid desc");
            return false;
        }

        if (!property_exists($obj, "brand_id") && !property_exists($obj, "brand")) {
            throw new \Exception("invalid brand");
            return false;
        }

        if ($checkBarcode && (!property_exists($obj, "barcode") || strlen($obj->barcode) !== 13)) {
            throw new \Exception("invalid barcode");
            return false;
        }
        return true;
    }
}
