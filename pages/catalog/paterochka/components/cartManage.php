<?php
if (!isset($_SESSION['user_id'])) {
	header("Location: /pages/auth/login.php");
	exit();
}

if (isset($_POST['increase'])) {
	$product_id = $_POST['product_id'];
	$query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ii", $user_id, $product_id);
	$stmt->execute();
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}

if (isset($_POST['decrease'])) {
	$product_id = $_POST['product_id'];
	$query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ii", $user_id, $product_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$new_quantity = $row['quantity'] - 1;

		if ($new_quantity <= 0) {
			$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ii", $user_id, $product_id);
			$stmt->execute();
		} else {
			$query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
			$stmt->execute();
		}
	}
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}

if (isset($_POST['product_id']) && !isset($_POST['increase']) && !isset($_POST['decrease'])) {
	$product_id = $_POST['product_id'];
	$quantity = 1;

	$query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ii", $user_id, $product_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$new_quantity = $row['quantity'] + 1;
		$query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
		$stmt->execute();
	} else {
		$query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("iii", $user_id, $product_id, $quantity);
		$stmt->execute();
	}

	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}

if (isset($_POST['clear_cart'])) {
	$query = "DELETE FROM cart WHERE user_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}
?>