<?php
namespace Compras\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('\Compras\Models\Product');
    }

    public function purchases()
    {
        return $this->belongsToMany('\Compras\Models\Purchase', 'purchase_items');
    }
}
