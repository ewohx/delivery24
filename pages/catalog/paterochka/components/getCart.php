<?php
function getCartItems($user_id, $conn)
{
	if (!$user_id) {
		return [];
	}
	$query = "SELECT c.product_id, c.quantity, p.name, p.price 
              FROM cart c 
              JOIN products p ON c.product_id = p.product_id 
              WHERE c.user_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$result = $stmt->get_result();

	$cartItems = [];
	while ($row = $result->fetch_assoc()) {
		$cartItems[] = $row;
	}

	return $cartItems;
}

$cartItems = getCartItems($user_id, $conn);
?>