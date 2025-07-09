<?php
session_start();
ob_start();
?>

<?php include 'components/notRead.php'; ?>

<?php include 'components/nav.php'; ?>

<?php include 'components/notGen.php'; ?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Главная' ?></title>
    <link rel="icon" href="/resources/icons/icon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="/pages/hedFot/styles/header.css" />
    <link rel="stylesheet" href="/pages/hedFot/styles/footer.css" />
    <link rel="stylesheet" href="/styles/index.css" />
    <link rel="stylesheet" href="/pages/catalog/styles/catalog.css" />
    <link rel="stylesheet" href="/pages/catalog/paterochka/styles/paterochka.css" />
    <link rel="stylesheet" href="/pages/authReg/register/styles/reg.css" />
    <link rel="stylesheet" href="/pages/checkout/styles/buy.css" />
    <link rel="stylesheet" href="/pages/profile/user/styles/profile.css" />
    <link rel="stylesheet" href="/pages/reviews/styles/reviews.css" />
    <link rel="stylesheet" href="/pages/profile/admin/styles/admin.css" />
    <link rel="stylesheet" href="/styles/fonts.css" />
    <link rel="stylesheet" href="/styles/root.css" />
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="header-container">
                <a href="/">
                    <?php
                    $logoDesktop = '/resources/icons/logo.svg';
                    if (strpos($_SERVER['REQUEST_URI'], 'paterochka') !== false) {
                        $logoDesktop = '/resources/icons/logoPya.svg';
                    } elseif (strpos($_SERVER['REQUEST_URI'], 'vita') !== false) {
                        $logoDesktop = '/resources/icons/logoVita.svg';
                    }
                    ?>

                    <img src="/resources/icons/logo.svg" alt="" class="logo logo-mobile" />

                    <img src="<?= $logoDesktop ?>" alt="" class="logo logo-desktop" />
                </a>
                <ul class="nav-item">
                    <?= $notificationHTML ?>
                    <?= $menu ?>
                </ul>
            </div>
        </header>

        <script src='/pages/hedFot/js/not.js'></script>
    </div>
</body>

</html>