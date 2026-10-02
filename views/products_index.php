<?php

/**
 * @var array $products
 */
?>

<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <title>Products</title>
</head>

<body>

    <main>
        <div class="card-container">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <div class="card-title">
                        <h2 class="card-name"><?= htmlspecialchars($product->name); ?></h2>
                    </div>
                    <div class="card-content">
                        <p class="card-description"><?= htmlspecialchars($product->description); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>