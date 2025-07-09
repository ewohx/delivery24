<?php
session_start();

include '../../../database/function/connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

$sql = sprintf("SELECT * FROM `user` WHERE `login` = '%s'", $login);
$result = $conn->query($sql);

if ($result && $result->num_rows) {
	$row = $result->fetch_assoc();

	if ($row['role'] === 'Администратор' || $row['role'] === 'Курьер') {
		if ($password === $row['password']) {
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['login'] = $row['login'];
			$_SESSION['role'] = $row['role'];

			header("Location: /pages/catalog/catalog.php");
			exit;
		} else {
			header("Location: /pages/authReg/auth/auth.php?message=Некорректный логин или пароль");
			exit;
		}
	} else {
		if (password_verify($password, $row['password'])) {
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['login'] = $row['login'];
			$_SESSION['role'] = $row['role'];

			header("Location: /pages/catalog/catalog.php");
			exit;
		} else {
			header("Location: /pages/authReg/auth/auth.php?message=Некорректный логин или пароль");
			exit;
		}
	}
} else {
	header("Location: /pages/authReg/auth/auth.php?message=Некорректный логин или пароль");
	exit;
}
?>