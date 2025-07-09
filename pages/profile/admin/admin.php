<?php
session_start();
include "../../hedFot/header.php";
include '../../../database/function/connect.php';
$pageTitle = "Админ панель";
include 'components/statusUpdate.php';
include 'components/questionResponse.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
	header("Location: login.php");
	exit;
}
$userRole = $_SESSION['role'];
?>
<?php include 'components/orderData.php'; ?>

<main>
	<div class="container">
		<div class="flex-container">
			<?php if ($userRole === 'Администратор'): ?>
				<div class="status-update">
					<h2 class="registration-title">Изменить статус доставки</h2>
					<?php include './components/statusForm.php'; ?>
				</div>

				<div class="question-response">
					<h2 class="registration-title">Ответы на вопросы пользователей</h2>
					<?php include './components/questionList.php'; ?>
				</div>
			<?php endif; ?>
			<?php include 'components/orderList.php'; ?>

		</div>
	</div>
	</div>
</main>

<?php
$conn->close();
include "../../hedFot/footer.php";
?>