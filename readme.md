<h1>Compras</h1>
Groceries management system. It has also a RESTful API to query products via barcode.

<i>I've decided to use PUT as update only actions to keep it's idempotency definition.
Use POST to add new and PUT to change products.</i>


<h4>Currently supported actions:</h4>

<ul>
	<li>
		<ul>Products:

	    	<li>GET at '/api/v1/products/{barcode}.json' - get a product by id</li>
	    	<li>POST at '/api/v1/products/json' - add a product</li>
    		<li>DELETE at '/api/v1/products/{barcode}' - delete a product by barcode</li>
    		<li>PUT at '/api/v1/products/{barcode}.json' - updates a product</li>
		</ul>
	</li>

	<li>
		<ul>Brands:
			<li>GET at '/api/v1/brands/json' - lists all brands</li>
			<li>GET at '/api/v1/brands/json/{id}' - get a brand by id</li>
			<li>POST at '/api/v1/brands/json' - add a brand
			<li>DELETE at '/api/v1/brands/json/{id}' - delete a brand by id</li>
		</ul>
	</li>

</ul>