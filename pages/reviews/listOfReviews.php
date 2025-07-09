<?php
include '../../database/function/connect.php';
include "../hedFot/header.php";
$pageTitle = "Список отзывов";

session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] == 'Администратор';
?>

<main>
	<div class="container">
		<h2 class="registration-title">Отзывы</h2>
		<?php include 'components/reviewsDisplay.php'; ?>
		<?php include 'components/reviewsDelete.php'; ?>
	</div>
</main>

<?php
include "../hedFot/footer.php";
?>