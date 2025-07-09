<?php
if (isset($_GET['action']) && $_GET['action'] === 'mark_notifications_read' && isset($_SESSION['user_id'])) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/database/function/connect.php';
	$userId = $_SESSION['user_id'];

	$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$stmt->close();

	header('Content-Type: application/json');
	echo json_encode(['success' => true]);
	exit;
}
?>