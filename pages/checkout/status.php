<?php
session_start();
$pageTitle = "Статус заказа";
include "./../hedFot/header.php";
include '../../database/function/connect.php';

if (isset($_SESSION['order_number'])) {
	$orderNumber = $_SESSION['order_number'];

	$stmt = $conn->prepare("SELECT status FROM delivery_application WHERE number = ?");
	$stmt->bind_param("s", $orderNumber);
	$stmt->execute();
	$stmt->bind_result($status);
	$stmt->fetch();
	$stmt->close();

	$statuses = ['Создан', 'Собирается', 'Скоро будем у вас', 'Доставлен'];
	$currentStatusIndex = array_search($status, $statuses);
	echo "<main>";
	echo "<div class='container'>";
	if ($currentStatusIndex !== false) {
		echo "<h2 class='registration-title'>Статус вашего заказа:</h2>";
		echo "<div id='statuses' class='statuses'>";
		foreach ($statuses as $index => $stat) {
			$class = ($index === $currentStatusIndex) ? 'current-status' : '';
			echo "<div class='status $class' id='status-$index'>" . $stat . "</div>";
		}
		echo "</div>";
	} else {
		echo "<h2 class='error-message'>Заказ не найден.</h2>";
	}
	echo "</div>";
} else {
	echo "<h2 class='error-message'>Нет информации о заказе.</h2>";
}
echo "</main>";

?>
<?php

include "./../hedFot/footer.php";
?>