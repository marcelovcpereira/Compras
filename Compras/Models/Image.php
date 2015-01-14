<?php
namespace Compras\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Represents an Image.
 *
 * @author Marcelo Pereira
 * @since 2015-01-03
 * @package Compras
 * @subpackage Models
 */
class Image extends Model implements \JsonSerializable
{
    protected $table = "images";
    public $timestamps = false;
    
    /**
     * Returns a JSON formatted string representation of the image.
     *
     * @return string(json) JSON representation of the image.
     */
    public function jsonify()
    {
        $newImage = array();
        $newImage["description"] = $this->description;
        $newImage["id"] = $this->id;
        $newImage["url"] = $this->url;
        $newImage["title"] = $this->title;
        $newImage["width"] = $this->width;
        $newImage["height"] = $this->height;

        return json_encode($newImage);
    }

    /**
     * JsonSerializable function.
     * @return array Array to be json encoded.
     */
    public function jsonSerialize()
    {
        return array(
            "description" => $this->description, 
            "id" => $this->id, 
            "url" => $this->url, 
            "title" => $this->title,
            "width" => $this->width,
            "height" => $this->height
        );
    }
}
