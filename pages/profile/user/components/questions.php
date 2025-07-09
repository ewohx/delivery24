<?php
echo "<div class='questions'>";
if ($userRole === 'Администратор') {
	$stmt = $conn->prepare("SELECT question_id, user_id, question_text, response_text, response_created_at FROM user_questions ORDER BY question_id DESC");
	$stmt->execute();
	$questionsResult = $stmt->get_result();

	if ($questionsResult->num_rows > 0) {
		while ($question = $questionsResult->fetch_assoc()) {
			echo "<div class='question'>";
			echo "<h2>Ваш вопрос:</h2>";
			echo "<p>" . htmlspecialchars($question['question_text']) . "</p>";
			echo "<p><strong>Ответ:</strong> " . htmlspecialchars($question['response_text'] ?? 'Нет ответа') . "</p>";
			echo "<p>Дата ответа: " . htmlspecialchars($question['response_created_at'] ?? 'Не ответили') . "</p>";
			echo "</div>";
		}
	} else {
		echo "<p class='error-message>Нет вопросов.</p>";
	}
} else {
	$stmt = $conn->prepare("SELECT question_id, question_text, response_text, response_created_at FROM user_questions WHERE user_id = ? ORDER BY question_id DESC");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$userQuestionsResult = $stmt->get_result();

	if ($userQuestionsResult->num_rows > 0) {
		while ($question = $userQuestionsResult->fetch_assoc()) {
			echo "<div class='question'>";
			echo "<h2>Ваш вопрос:</h2>";
			echo "<p>" . htmlspecialchars($question['question_text']) . "</p>";
			echo "<p><strong>Ответ:</strong> " . htmlspecialchars($question['response_text'] ?? 'Нет ответа') . "</p>";
			echo "<p>Дата ответа: " . htmlspecialchars($question['response_created_at'] ?? 'Не ответили') . "</p>";
			echo "</div>";
		}
	} else {
		echo "<p>Вы еще не задавали вопросов.</p>";
	}
}
echo "</div>";
?>