<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status']) && $userRole === 'Курьер') {
	$appId = $_POST['application_id'];
	$newStatus = $_POST['new_status'];

	$update = $conn->prepare("UPDATE delivery_application SET status = ? WHERE application_id = ? AND courier_id = ?");
	$update->bind_param("sii", $newStatus, $appId, $courierId);
	$update->execute();
	$update->close();

	if ($newStatus === 'Доставлен') {
		$freeCourier = $conn->prepare("UPDATE couriers SET status = 'Свободен' WHERE courier_id = ?");
		$freeCourier->bind_param("i", $courierId);
		$freeCourier->execute();
		$freeCourier->close();
	}
}
?>