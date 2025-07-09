<?php
if (isset($_SESSION['login']) && isset($_SESSION['user_id'])) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/database/function/connect.php';

	$userId = $_SESSION['user_id'];
	$unreadCount = 0;

	$stmtUnread = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
	$stmtUnread->bind_param("i", $userId);
	$stmtUnread->execute();
	$stmtUnread->bind_result($unreadCount);
	$stmtUnread->fetch();
	$stmtUnread->close();


	$stmtNotif = $conn->prepare("SELECT order_number, status, timestamp, is_read FROM notifications WHERE user_id = ? ORDER BY timestamp DESC LIMIT 5");
	$stmtNotif->bind_param("i", $userId);
	$stmtNotif->execute();
	$result = $stmtNotif->get_result();

	$notificationHTML .= '<li class="nav-item dropdown notification-dropdown">
        <div class="nav-link" onclick="toggleNotificationDropdown()">
            <img src="/resources/icons/bell.svg" alt="Уведомления" class="person-circle">
            <div class="nav-text">Уведомления';

	if ($unreadCount > 0) {
		$notificationHTML .= "<span class='notification-count'>$unreadCount</span>";
	}

	$notificationHTML .= '</div>
        </div>
        <ul class="dropdown-menu notification-menu">';

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$notificationHTML .= '<li class="dropdown-item' . ($row['is_read'] ? '' : ' unread') . '">
                <strong>' . htmlspecialchars($row['status']) . '</strong><br>
                Заказ №' . htmlspecialchars($row['order_number']) . '<br>
                <small>' . htmlspecialchars($row['timestamp']) . '</small>
            </li>';
		}
	} else {
		$notificationHTML .= '<li class="dropdown-item">Уведомлений нет</li>';
	}

	$notificationHTML .= '</ul></li>';

	$stmtNotif->close();
}
?>