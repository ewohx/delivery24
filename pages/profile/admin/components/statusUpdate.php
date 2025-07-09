<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_number'], $_POST['status'])) {
	$orderNumber = $_POST['order_number'];
	$newStatus = $_POST['status'];

	$conn->begin_transaction();
	try {

		$stmt = $conn->prepare("UPDATE delivery_application SET status = ? WHERE number = ?");
		$stmt->bind_param("ss", $newStatus, $orderNumber);
		$stmt->execute();
		if ($stmt->affected_rows === 0) {
			throw new Exception("Заказ не найден или статус не изменен.");
		}
		$stmt->close();


		$getUserStmt = $conn->prepare("SELECT user_id, application_id FROM delivery_application WHERE number = ?");
		$getUserStmt->bind_param("s", $orderNumber);
		$getUserStmt->execute();
		$getUserStmt->bind_result($userId, $applicationId);
		$getUserStmt->fetch();
		$getUserStmt->close();


		if ($newStatus === 'Доставлен') {
			$updateCourierStmt = $conn->prepare("UPDATE couriers SET status = 'Свободен' WHERE courier_id = (SELECT courier_id FROM delivery_application WHERE application_id = ?)");
			$updateCourierStmt->bind_param("i", $applicationId);
			$updateCourierStmt->execute();
			$updateCourierStmt->close();
		}


		$insertNotif = $conn->prepare("INSERT INTO notifications (user_id, order_number, status, timestamp, is_read) VALUES (?, ?, ?, NOW(), 0)");
		$insertNotif->bind_param("iss", $userId, $orderNumber, $newStatus);
		$insertNotif->execute();
		$insertNotif->close();

		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		echo "<div class='error-message'>" . htmlspecialchars($e->getMessage()) . "</div>";
	}
}
?>