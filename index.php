<?php
session_start();
$pageTitle = "Курьер 24";
include "pages/hedFot/header.php";
?>

<body>
    <main class='login-page-main'>
        <div class="body-container">
            <h1 class='text-delivery-one'>Курьерская служба "Курьер 24"</h1>
            <p class='text-delivery-two'>Быстрая доставка по микрорайону "Уралмаш"</p>
            <div class="catalog">
                <?php if (isset($_SESSION['login'])): ?>
                    <div class="link-cat" onclick="location.href='pages/catalog/catalog.php'">К магазинам</div>
                <?php else: ?>
                    <div class="link-cat" onclick="location.href='pages/authReg/auth/auth.php'">К магазинам</div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
<?php
include "pages/hedFot/footer.php";
?>