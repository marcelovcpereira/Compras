<?php

namespace Compras\Controllers;

use \Compras\Models\Purchase;
use \Compras\Models\Item;

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
