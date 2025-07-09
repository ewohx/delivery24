<?php
session_start();

if (isset($_SESSION['login'])) {
	unset($_SESSION['login']);
}
if (isset($_SESSION['role'])) {
	unset($_SESSION['role']);
}
header("Location: /");
exit;
?>