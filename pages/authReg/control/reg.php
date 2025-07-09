<?php
session_start();

include '../../../database/function/connect.php';

$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO `user`(`login`, `email`, `phone`, `password`, `role`) VALUES (?, ?, ?, ?, 'Пользователь')");
$stmt->bind_param("ssss", $_POST['login'], $_POST['email'], $_POST['phone'], $hashed_password);

if (!$stmt->execute()) {
	echo "Ошибка добавления данных";
} else {
	$_SESSION['user_id'] = $conn->insert_id;
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['role'] = "Пользователь";
	header("Location: /pages/profile/user/profile.php");
	exit;
}
?>