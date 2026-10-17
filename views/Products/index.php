<main>
    <div class="card-container">
        <?php foreach (isset($products) ? $products : [] as $product): ?>
        <div class="card">
            <a href="/products/<?= $product->id ?>/show">
                <div class="card-title">
                    <h2 class="card-name"><?= htmlspecialchars($product->name); ?></h2>
                </div>
                <div class="card-content">
                    <p class="card-description"><?= htmlspecialchars($product->description); ?></p>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</main>