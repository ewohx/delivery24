<?php
session_start();
include "../../hedFot/header.php";
include '../../../database/function/connect.php';
$pageTitle = "Курьерская панель";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
	header("Location: login.php");
	exit;
}

$userRole = $_SESSION['role'];
$userId = $_SESSION['user_id'];
$courierId = null;

if ($userRole === 'Курьер') {
	$courierStmt = $conn->prepare("SELECT courier_id FROM couriers WHERE user_id = ?");
	$courierStmt->bind_param("i", $userId);
	$courierStmt->execute();
	$courierResult = $courierStmt->get_result();
	if ($courierResult->num_rows > 0) {
		$courier = $courierResult->fetch_assoc();
		$courierId = $courier['courier_id'];
	}
	$courierStmt->close();
}

$statuses = ['Создан', 'Собирается', 'Скоро будем у вас', 'Доставлен'];
?>
<?php include 'components/courierOrder.php'; ?>

<?php include 'components/statusUpdate.php'; ?>

<?php include 'components/orderData.php'; ?>

<?php include 'components/courierUpdate.php'; ?>

<?php include 'components/orderDisplay.php'; ?>

<?php include "../../hedFot/footer.php"; ?>