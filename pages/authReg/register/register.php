<?php
session_start();
$pageTitle = "Регистрация";
if (isset($_SESSION['login'])) {
	header("Location: /pages/profile/user/profile.php");
	exit;
}
include "../../hedFot/header.php";
?>
<main>
	<section class="registration-page">
		<div class="container">
			<h1 class="registration-title">Регистрация</h1>
			<form action="/pages/authReg/control/reg.php" method="post" class="registration-form">
				<div class="form-group">
					<label for="login" class="form-label">Логин</label>
					<input type="text" class="form-control" id="login" name="login" required>
				</div>
				<div class="form-group">
					<label for="email" class="form-label">Адрес электронной почты</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="phone" class="form-label">Телефон</label>
					<input type="tel" class="form-control" id="phone" name="phone" required>
				</div>
				<div class="form-group">
					<label for="password" class="form-label">Пароль</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<div class="form-group">
					<label for="password-repeat" class="form-label">Повторите пароль</label>
					<input type="password" class="form-control" id="password-repeat" name="password-repeat" required>
				</div>
				<input type="submit" class="button-reg" value="Зарегистрироваться">
			</form>
		</div>
	</section>
</main>
<?php
include "../../hedFot/footer.php";
?>