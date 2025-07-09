<?php
session_start();
$pageTitle = "Каталог";
include "./../hedFot/header.php";
?>
<main class='shop-container-main'>
	<h1 class="shop-title">Магазины</h1>
	<div class="shop-container">
		<?php
		include './../../database/function/connect.php';
		$storeQuery = "SELECT * FROM stores";
		$storeResult = $conn->query($storeQuery);

		if ($storeResult->num_rows > 0) {
			while ($store = $storeResult->fetch_assoc()): ?>
				<div onclick="location.href='<?= strtolower($store['name']) ?>/<?= strtolower($store['name']) ?>.php'">
					<img class='pya' src="../../../resources/icons/<?= htmlspecialchars($store['logo']) ?>"
						alt="<?= htmlspecialchars($store['name']) ?>" class="store-logo">
				</div>
			<?php endwhile; ?>
		<?php } else { ?>
			<p>Магазины не найдены.</p>
		<?php } ?>
	</div>
</main>
<?php
$conn->close();
include "./../hedFot/footer.php";
?>