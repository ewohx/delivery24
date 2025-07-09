<?php

if (!isset($_SESSION['sort'])) {
	$_SESSION['sort'] = 'price_asc';
}
$sort = $_SESSION['sort'];
$category = isset($_SESSION['category']) ? $_SESSION['category'] : 'all';
$store_id = isset($_SESSION['store_id']) ? $_SESSION['store_id'] : 1;

if (isset($_POST['toggle_sort'])) {
	$sort = ($_SESSION['sort'] === 'price_asc') ? 'price_desc' : 'price_asc';
	$_SESSION['sort'] = $sort;
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}
if (isset($_POST['category'])) {
	$category = $_POST['category'];
	$_SESSION['category'] = $category;
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}

$categoryQuery = "SELECT DISTINCT category FROM products WHERE store_id = ?";
$stmt = $conn->prepare($categoryQuery);
$stmt->bind_param("i", $store_id);
$stmt->execute();
$categoryResult = $stmt->get_result();
$categories = [];
while ($row = $categoryResult->fetch_assoc()) {
	$categories[] = $row['category'];
}

$sortQuery = ($sort === 'price_asc') ? " ORDER BY price ASC" : " ORDER BY price DESC";
$categoryFilter = ($category !== 'all') ? " AND category = ?" : "";
$query = "SELECT * FROM products WHERE store_id = ?" . $categoryFilter . $sortQuery;

$stmt = $conn->prepare($query);
if ($category !== 'all') {
	$stmt->bind_param("is", $store_id, $category);
} else {
	$stmt->bind_param("i", $store_id);
}
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>