<div id="cart" class="cart">
	<div class="cart-header">
		<h2>Корзина</h2>
		<form method="POST">
			<input type="hidden" name="clear_cart" value="1">
			<div class="button-trash" onclick="this.closest('form').submit()">Очистить корзину</div>
		</form>
	</div>
	<ul>
		<?php foreach ($cartItems as $item): ?>
			<li>
				<div class="cart-item">
					<span class="product-name"><?= $item['name'] ?>: <?= $item['quantity'] ?>	шт</span>
					<form method="POST" style="display:inline;">
						<input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
						<input type="hidden" name="increase" value="1">
						<div class="button-add" onclick="this.closest('form').submit()">+</div>
					</form>
					<form method="POST" style="display:inline;">
						<input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
						<input type="hidden" name="decrease" value="1">
						<div class="button-remove" onclick="this.closest('form').submit()">-</div>
					</form>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php
	$totalPrice = 0;
	foreach ($cartItems as $item) {
		$totalPrice += $item['quantity'] * $item['price'];
	}
	?>

	<?php if (!empty($cartItems)): ?>
		<form action="/pages/checkout/buy.php" method="GET" class="checkout-form">
			<input type="hidden" name="products" value="<?php echo htmlspecialchars(json_encode(array_map(function ($item) {
				return ['product_id' => $item['product_id'], 'quantity' => $item['quantity']];
			}, $cartItems))); ?>">
			<input type="hidden" name="total" value="<?= $totalPrice ?>">
			<p class="cart-price" onclick="this.closest('form').submit()">К оплате: <?= $totalPrice ?>	руб</p>
		</form>
	<?php endif; ?>
</div>