<div class="orders-list">
	<h2 class="registration-title">Информация о заказах</h2>
	<?php
	if (!empty($orders)) {
		echo "<div class='orders'>";
		foreach ($orders as $order) {
			echo "<div class='order'>";
			echo "<h3>Заказ номер: " . htmlspecialchars($order['number']) . "</h3>";
			echo "<p>Статус: " . htmlspecialchars($order['status']) . "</p>";
			echo "<p>Адрес: " . htmlspecialchars($order['address']) . "</p>";


			$products = json_decode($order['products'], true);
			$productList = [];
			foreach ($products as $productItem) {
				$productId = $productItem['product_id'];
				$quantity = $productItem['quantity'];

				$productQuery = "SELECT name FROM products WHERE product_id = ?";
				$productStmt = $conn->prepare($productQuery);
				$productStmt->bind_param("i", $productId);
				$productStmt->execute();
				$productResult = $productStmt->get_result();

				if ($productResult->num_rows > 0) {
					$product = $productResult->fetch_assoc();
					$productName = $product['name'];
					$productList[] = $productName . " (" . $quantity . " шт)";
				}
				$productStmt->close();
			}

			$productsString = implode(", ", $productList);
			echo "<p>Товары: " . htmlspecialchars($productsString) . "</p>";
			echo "<p>Цена: " . htmlspecialchars($order['price']) . " руб.</p>";
			echo "<p>Время доставки: " . htmlspecialchars($order['delivery_time']) . "</p>";


			echo "<p>Курьер: " . ($order['courier_id'] ? htmlspecialchars($order['courier_name']) : "Не назначен") . "</p>";

			echo "</div>";
		}
		echo "</div>";
	} else {
		echo "<p class='error-message'>Нет заказов.</p>";
	}
	?>
</div>