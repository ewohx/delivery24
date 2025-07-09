<?php
$pageTitle = "Отзывы";
include '../../database/function/connect.php';
include "../hedFot/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_id = $_SESSION['user_id'];
	$review_text = $conn->real_escape_string($_POST['review_text']);
	$sql = "INSERT INTO reviews (user_id, review_text) VALUES ('$user_id', '$review_text')";

	if ($conn->query($sql) !== TRUE) {
		echo "<p class='error-message'>Ошибка: " . $sql . "<br>" . $conn->error . "</p>";
	}
}
?>

<?php include 'components/reviewsForm.php'; ?>


<?php
include "../hedFot/footer.php";
?>