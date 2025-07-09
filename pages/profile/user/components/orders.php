<?php
$query = "SELECT * FROM delivery_application WHERE user_id = ? ORDER BY application_id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

echo "<div class='orders'>";
if ($result->num_rows > 0) {
	while ($order = $result->fetch_assoc()) {
		echo "<div class='order'>";
		echo "<h2>Заказ номер: " . htmlspecialchars($order['number']) . "</h2>";
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
		}

		$productsString = implode(", ", $productList);
		echo "<p>Товары: " . htmlspecialchars($productsString) . "</p>";
		echo "<p>Цена: " . htmlspecialchars($order['price']) . " руб.</p>";
		echo "<p>Время доставки: " . htmlspecialchars($order['delivery_time']) . "</p>";
		echo "</div>";
	}
} else {
	echo "<p>У вас нет заказов.</p>";
}
echo "</div>";
?>