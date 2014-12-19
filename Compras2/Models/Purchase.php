<?php

namespace Compras2\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	protected $table = "purchases";
	public $timestamps = false;

	public function items()
	{
		return $this->belongsToMany('\Compras2\Models\Item','purchase_items');
	}
}