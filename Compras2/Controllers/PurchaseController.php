<?php

namespace Compras2\Controllers;

use \Compras2\Models\Purchase;
use \Compras2\Models\Item;

class PurchaseController
{
	public function purchases()
	{
		foreach (Purchase::all() as $purchase) {
			echo "Purchase at " . $purchase->market . " (on " . $purchase->date . "):<br><ul>";
			foreach ($purchase->items as $item) {
				echo "<li>" . $item->quantity . "x. " . $item->product->name . " - R\$" . $item->unitPrice  . "</li>";
			}
			echo "</ul>";
		}
	}
}