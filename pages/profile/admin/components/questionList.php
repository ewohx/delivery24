<?php
$questionsQuery = $conn->query("
    SELECT q.question_id, q.question_text, q.response_text, u.login 
    FROM user_questions q 
    JOIN user u ON q.user_id = u.user_id 
    ORDER BY q.question_id DESC
");

if ($questionsQuery->num_rows > 0): ?>
	<?php while ($question = $questionsQuery->fetch_assoc()): ?>
		<div class="question">
			<h2>Вопрос от пользователя <?php echo htmlspecialchars($question['login']); ?>:</h2>
			<p><?php echo htmlspecialchars($question['question_text']); ?></p>
			<p><strong>Ответ:</strong> <?php echo htmlspecialchars($question['response_text'] ?? 'Нет ответа'); ?></p>

			<form method="POST" action="">
				<input type="hidden" name="question_id" value="<?php echo $question['question_id']; ?>">
				<label for="response_text">Ваш ответ:</label>
				<textarea id="response_text" name="response_text" rows="4" required></textarea>
				<button type="submit" class='button-reg'>Отправить ответ</button>
			</form>
		</div>
	<?php endwhile; ?>
<?php else: ?>
	<p class='error-message'>Нет вопросов от пользователей.</p>
<?php endif; ?>