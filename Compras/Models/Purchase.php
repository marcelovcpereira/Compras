<?php

namespace Compras\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "purchases";
    public $timestamps = false;

    public function items()
    {
        return $this->belongsToMany('\Compras\Models\Item', 'purchase_items');
    }
}
