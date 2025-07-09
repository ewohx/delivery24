<?php
$menu = "";

if (isset($_SESSION['login']) && isset($_SESSION['user_id'])) {
    $menu .= '<li class="nav-item dropdown">
            <div class="nav-link profile-toggle">
                <img src="/resources/icons/person-circle.svg" alt="" class="person-circle">
                <div class="nav-text">Профиль</div>
            </div>
            <ul class="dropdown-menu">';

    if ($_SESSION['role'] == "Администратор") {
        $menu .= '<li>
                <div class="dropdown-item first" onclick="location.href=\'/pages/profile/admin/admin.php\'">
                    <img src="/resources/icons/gear.svg" alt="" class="person-circle">
                    <div class="nav-text">Панель администратора</div>
                </div>
              </li>';
    }

    if ($_SESSION['role'] == "Курьер") {
        $menu .= '<li>
                <div class="dropdown-item first" onclick="location.href=\'/pages/profile/courier/courier.php\'">
                    <img src="/resources/icons/gear.svg" alt="" class="person-circle">
                    <div class="nav-text">Панель курьера</div>
                </div>
              </li>';
    }

    $menu .= '<li>
            <div class="dropdown-item first" onclick="location.href=\'/pages/profile/user/profile.php\'">
                <img src="/resources/icons/question.svg" alt="" class="person-circle">
                <div class="nav-text">Заказы и вопросы</div>
            </div></li>
            <li>
                <div class="dropdown-item" onclick="location.href=\'/pages/support/support.php\'">
                    <img src="/resources/icons/question-circle.svg" alt="" class="person-circle">
                    <div class="nav-text">Поддержка</div>
                </div>
            </li>
            <li>
                <div class="dropdown-item" onclick="location.href=\'/pages/reviews/reviews.php\'">
                    <img src="/resources/icons/chat-text.svg" alt="" class="person-circle">
                    <div class="nav-text">Отзывы</div>
                </div>
            </li>
            <li>
                <div class="dropdown-item last" onclick="location.href=\'/pages/authReg/control/logout.php\'">
                    <img src="/resources/icons/x-circle.svg" alt="" class="person-circle">
                    <div class="nav-text">Выйти</div>
                </div>
            </li>
            </ul>
        </li>';
} else {
    $menu = '<li class="nav-item">
            <div class="nav-link" onclick="location.href=\'/pages/authReg/auth/auth.php\'">
                <img src="/resources/icons/person-circle.svg" alt="" class="person-circle">
                <div class="nav-text">Войти</div>
            </div>
        </li>';
}
?>