<?php
namespace Compras\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Brand extends Model
{
    protected $table = "brands";
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('\Compras\Models\Product');
    }
}
