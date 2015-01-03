<?php
namespace Compras2\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('\Compras2\Models\Product');
    }

    public function purchases()
    {
        return $this->belongsToMany('\Compras2\Models\Purchase', 'purchase_items');
    }
}
