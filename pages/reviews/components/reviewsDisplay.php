<?php
$sql = "SELECT r.review_id, r.review_text, r.created_at, u.login 
                FROM reviews r 
                JOIN user u ON r.user_id = u.user_id 
                ORDER BY r.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo "<div class='review' style='position: relative;'>";
		echo "<strong>" . htmlspecialchars($row['login']) . "</strong> (" . $row['created_at'] . ")<br>";
		echo "<p>" . htmlspecialchars($row['review_text']) . "</p>";

		if ($isAdmin) {
			echo "<form method='POST' action='' style='position: absolute; top: 5px; right: 5px;'>";
			echo "<input type='hidden' name='review_id' value='" . $row['review_id'] . "'>";
			echo "<button type='submit' name='delete_review' style='background: none; border: none; cursor: pointer; color: red; font-size: 16px;'>×</button>";
			echo "</form>";
		}

		echo "</div>";
	}
} else {
	echo "<p class='error-message'>Нет отзывов.</p>";
}
?>