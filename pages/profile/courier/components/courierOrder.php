<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['take_order']) && $userRole === 'Курьер') {
	$applicationId = $_POST['application_id'];
	$conn->begin_transaction();
	try {
		$stmt = $conn->prepare("UPDATE delivery_application SET courier_id = ?, status = 'Собирается' WHERE application_id = ? AND courier_id IS NULL");
		$stmt->bind_param("ii", $courierId, $applicationId);
		$stmt->execute();
		if ($stmt->affected_rows === 0)
			throw new Exception("Заказ уже занят другим курьером.");
		$stmt->close();

		$setBusy = $conn->prepare("UPDATE couriers SET status = 'Занят' WHERE courier_id = ?");
		$setBusy->bind_param("i", $courierId);
		$setBusy->execute();
		$setBusy->close();

		$conn->commit();
		header("Location: " . $_SERVER['PHP_SELF']);
		exit;
	} catch (Exception $e) {
		$conn->rollback();
		echo "<div class='error-message'>" . $e->getMessage() . "</div>";
	}
}
?>