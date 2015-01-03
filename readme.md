<h1>Compras</h1>
Groceries management system. It has also a RESTful API to query products via barcode.

<i>I've decided to use PUT as update only actions to keep it's idempotency definition.
Use POST to add new and PUT to delete products.</i>


<h4>Currently supported actions:</h4>

<ul>
    <li>Return a JSON formatted product: GET at '/api/v1/products/{barcode}.json'</li>

    <li>Insert a JSON formatted product: POST at '/api/v1/products/{barcode}.json'</li>

    <li>Delete a product: DELETE at '/api/v1/products/{barcode}'</li>

    <li>Updates a product using JSON: PUT at '/api/v1/products/{barcode}.json'</li>
</ul>