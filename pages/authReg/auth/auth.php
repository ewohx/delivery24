<?php
session_start();
$pageTitle = "Логин";
if (isset($_SESSION['login'])) {
	header("Location: /pages/catalog/catalog.php");
	exit;
}
include "../../hedFot/header.php";
?>
<main>
	<section class="login-page">
		<div class="container">
			<?php
			if (isset($_GET['message'])) {
				echo "<div class='error-message'>{$_GET['message']}</div>";
			}
			?>
			<h1 class="registration-title">Вход</h1>
			<form action="/pages/authReg/control/login.php" method="post" class="login-form">
				<div class="form-group">
					<label for="login" class="form-label">Ваш логин</label>
					<input type="text" class="form-control" id="login" name="login" required>
				</div>
				<div class="form-group">
					<label for="password" class="form-label">Ваш пароль</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<input type="submit" class="button-reg" value="Войти">
			</form>
			<div class="registration-link">
				<span>Нет аккаунта?</span>
				<div class="reg-link" onclick="location.href='/pages/authReg/register/register.php'">Зарегистрируйтесь
				</div>
			</div>
		</div>
	</section>
</main>
<?php
include "../../hedFot/footer.php";
?>