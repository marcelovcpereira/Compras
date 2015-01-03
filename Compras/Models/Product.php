<?php
namespace Compras\Models;

/**
 * Represents a product object.
 *
 * @author Marcelo Pereira
 * @since 2015-01-03
 * @package Compras
 * @subpackage Models
 */
class Product extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "product";
    public $timestamps = false;

    ////////////////////////////////////////
    //attributes to be added in the future//
    //peso                                //
    //volume                              //
    //medidas                             //
    //categoria: alimentos                //
    //subcategoria: conservas e enlatados //
    ////////////////////////////////////////

    /**
     * Eloquent representation of relationship.
     */
    public function brand()
    {
        return $this->belongsTo("\Compras\Models\Brand");
    }

    /**
     * Returns a JSON formatted string representation of the product.
     *
     * @return string(json) JSON representation of the product.
     */
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

    /**
     * Creates a Product instance from a JSON object.
     *
     * @param  string $json JSON formatted product.
     * @return \Compras\Models\Product       A product instance.
     */
    public static function createFromJson($json)
    {
        $obj = json_decode($json);
        if ($obj && self::validate($obj)) {
            $product = new Product();
            $product->name = $obj->name;
            $product->description = $obj->description;
            $product->brand_id = $obj->brand;
            $product->barcode = $obj->barcode;
            return $product;
        }
        throw new \Exception("Invalid JSON");
    }

    /**
     * Updates the Product object from a JSON.
     *
     * @param  string $json JSON formatted product.
     * @return void
     */
    public function updateFromJson($json)
    {
        $obj = json_decode($json);
        if ($obj && self::validate($obj, false)) {
            $this->name = $obj->name;
            $this->description = $obj->description;
            $this->brand_id = $obj->brand;
        } else {
            throw new \Exception("Bad format exception");
        }
    }

    /**
     * Checks the validity of an object accordingly to Product class
     * properties.
     *
     * @param  stdClass  $obj          Object (stdClass) to be validated.
     * @param  boolean $checkBarcode Flag to indicate if the barcode needs check.
     * @return boolean               True if object is valid. An Exception otherwise.
     */
    public static function validate($obj, $checkBarcode = true)
    {
        if (!property_exists($obj, "name")) {
            throw new \Exception("invalid name");
        }

        if (!property_exists($obj, "description")) {
            throw new \Exception("invalid desc");
        }

        if (!property_exists($obj, "brand_id") && !property_exists($obj, "brand")) {
            throw new \Exception("invalid brand");
        }

        if ($checkBarcode && (!property_exists($obj, "barcode") || strlen($obj->barcode) !== 13)) {
            throw new \Exception("invalid barcode");
        }
        return true;
    }
}
