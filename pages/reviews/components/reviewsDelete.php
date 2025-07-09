<?php
if ($isAdmin && isset($_POST['delete_review']) && isset($_POST['review_id'])) {
	$review_id = (int) $_POST['review_id'];
	$delete_sql = "DELETE FROM reviews WHERE review_id = ?";

	if ($stmt = $conn->prepare($delete_sql)) {
		$stmt->bind_param("i", $review_id);
		if ($stmt->execute()) {
			echo "<p class='success-message'>Отзыв успешно удален.</p>";
			header("Location: " . $_SERVER['PHP_SELF']);
			exit();
		} else {
			echo "<p class='error-message'>Ошибка при удалении отзыва.</p>";
		}
		$stmt->close();
	} else {
		echo "<p class='error-message'>Ошибка подготовки запроса.</p>";
	}
}
$conn->close();
?>