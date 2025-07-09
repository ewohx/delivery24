<?php
session_start();
$pageTitle = "Поддержка";

include '../../database/function/connect.php';
include '../hedFot/header.php';


$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$questionText = trim($_POST['question_text']);

	if (!empty($questionText)) {
		$stmt = $conn->prepare("INSERT INTO user_questions (user_id, question_text) VALUES (?, ?)");
		$stmt->bind_param("is", $userId, $questionText);
		$stmt->execute();
		$stmt->close();

	}
}
?>

<?php include 'components/supportForm.php'; ?>

<?php
include '../hedFot/footer.php';
?>