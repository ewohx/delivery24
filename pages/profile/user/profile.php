<?php
session_start();
$pageTitle = "Заказы и вопросы";
include '../../../database/function/connect.php';
include "../../hedFot/header.php";

if (!isset($_SESSION['user_id'])) {
	echo "<h1 class='error-message'>Пожалуйста, войдите в систему, чтобы просмотреть свои заказы.</h1>";
	exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT role FROM user WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($userRole);
$stmt->fetch();
$stmt->close();

echo "<main>";
echo "<div class='container'>";
echo "<h2 class='registration-title'>Ваши заказы и вопросы</h2>";
echo "<div class='flex-container'>";


include 'components/orders.php';
include 'components/questions.php';

echo "</div>";
echo "</div>";
echo "</main>";

$stmt->close();
$conn->close();
?>
<?php
include "../../hedFot/footer.php";
?>