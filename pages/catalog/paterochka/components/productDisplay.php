<main>
	<div class="main-container">
		<div class="product-container">
			<div class="sort-controls">
				<form method="POST">
					<select name="category" id="category" onchange="this.form.submit()">
						<option value="all" <?php echo ($category === 'all') ? 'selected' : ''; ?>>Все категории</option>
						<?php foreach ($categories as $cat): ?>
							<option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($category === $cat) ? 'selected' : ''; ?>>
								<?php echo htmlspecialchars($cat); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</form>
				<form method="POST">
					<input type="hidden" name="toggle_sort" value="1">
					<p class='sort' onclick="this.closest('form').submit();">
						Сортировать по цене: <?php echo ($sort === 'price_asc') ? '↑' : '↓'; ?>
					</p>
				</form>
			</div>

			<?php if (empty($products)): ?>
				<p>Товары не найдены.</p>
			<?php else: ?>
				<?php foreach ($products as $product): ?>
					<div class="product-card">
						<img src="../../../resources/products/<?= htmlspecialchars($product['image']) ?>" alt=""
							class="product-image">
						<div class="product-details">
							<p><?= htmlspecialchars($product['name']) ?></p>
							<h2><?= htmlspecialchars($product['price']) ?>	руб</h2>
							<form method="POST">
								<input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
								<div class="button" onclick="this.closest('form').submit()">+</div>
							</form>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>