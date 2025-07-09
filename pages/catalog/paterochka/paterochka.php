<?php
session_start();
include "../../hedFot/header.php";
include '../../../database/function/connect.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$pageTitle = "Пятерочка";


$storeQuery = "SELECT store_id, name FROM stores WHERE name = 'Пятерочка'";
$storeResult = $conn->query($storeQuery);
if ($storeResult->num_rows > 0) {
	$store = $storeResult->fetch_assoc();
	$store_id = $store['store_id'];
	$pageTitle = htmlspecialchars($store['name']);
} else {
	$store_id = 1;
	$pageTitle = "Пятерочка";
}

$_SESSION['store_id'] = $store_id;

?>

<?php include 'components/getCart.php'; ?>
<?php include 'components/cartManage.php'; ?>
<?php include 'components/productSort.php'; ?>
<?php include 'components/productDisplay.php'; ?>
<?php include 'components/cartDisplay.php'; ?>

<?php
$conn->close();
?>