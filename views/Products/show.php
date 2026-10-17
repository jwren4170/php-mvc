<h1>Product Show Page</h1>
<p>Product ID: <?= isset($product) ? $product->id : 'N/A' ?></p>
<p>Product Name: <?= isset($product) ? $product->name : 'N/A' ?></p>
<p>Product Description: <?= isset($product) ? $product->description : 'N/A' ?></p>
<a href="/products">Back to products</a>