<?php
if ($userRole === 'Курьер' && $courierId !== null) {
	$checkActiveStmt = $conn->prepare("SELECT COUNT(*) as active_count FROM delivery_application WHERE courier_id = ? AND status != 'Доставлен'");
	$checkActiveStmt->bind_param("i", $courierId);
	$checkActiveStmt->execute();
	$result = $checkActiveStmt->get_result();
	$data = $result->fetch_assoc();
	$checkActiveStmt->close();

	if ($data['active_count'] == 0) {
		$setFree = $conn->prepare("UPDATE couriers SET status = 'Свободен' WHERE courier_id = ?");
		$setFree->bind_param("i", $courierId);
		$setFree->execute();
		$setFree->close();
	}
}
?>