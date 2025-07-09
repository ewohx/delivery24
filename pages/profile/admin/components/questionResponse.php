<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['response_text'], $_POST['question_id'])) {
	$responseText = trim($_POST['response_text']);
	$questionId = $_POST['question_id'];

	if (!empty($responseText)) {
		$stmt = $conn->prepare("UPDATE user_questions SET response_text = ?, response_created_at = NOW() WHERE question_id = ?");
		$stmt->bind_param("si", $responseText, $questionId);


		$stmt->close();
	} else {
		echo "<h1 class='error-message'>Пожалуйста, введите текст ответа.</h1>";
	}
}
