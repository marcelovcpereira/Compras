<?php
namespace Compras\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Represents a Brand of a product.
 *
 * @author Marcelo Pereira
 * @since 2015-01-03
 * @package Compras
 * @subpackage Models
 */
class Brand extends Model implements \JsonSerializable
{
    protected $table = "brands";
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('\Compras\Models\Product');
    }

    /**
     * Creates a Brand instance from a JSON object.
     *
     * @param  string $json JSON formatted brand.
     * @return \Compras\Models\Brand       A brand instance.
     */
    public static function createFromJson($json)
    {
        $obj = json_decode($json);
        if ($obj && self::validate($obj)) {
            $brand = new Brand();
            $brand->name = $obj->name;
            return $brand;
        }
        throw new \Exception("Invalid JSON");
    }

    /**
     * Checks the validity of an object accordingly to Brand class
     * properties.
     *
     * @param  stdClass  $obj          Object (stdClass) to be validated.
     * @return boolean               True if object is valid. An Exception otherwise.
     */
    public static function validate($obj)
    {
        if (!property_exists($obj, "name")) {
            throw new \Exception("property name is required");
        }
        return true;
    }

    /**
     * Returns a JSON formatted string representation of the brand.
     *
     * @return string(json) JSON representation of the brand.
     */
    public function jsonify()
    {
        $newBrand = array();
        $newBrand["name"] = $this->name;
        return json_encode($newBrand);
    }

    /**
     * JsonSerializable function.
     * @return array Array to be json encoded.
     */
    public function jsonSerialize()
    {
        return array("name" => $this->name);
    }
}
