<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>

<body>
    <h1>Product Show Page</h1>
    <p>This is the show page for a specific product.</p>
    <p>Product ID: <?= isset($product) ? $product->id : 'N/A' ?></p>
    <p>Product Name: <?= isset($product) ? $product->name : 'N/A' ?></p>
    <p>Product Description: <?= isset($product) ? $product->description : 'N/A' ?></p>

</body>

</html>