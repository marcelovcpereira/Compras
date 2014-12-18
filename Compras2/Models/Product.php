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
}