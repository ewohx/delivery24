<?php
session_start();
$pageTitle = "Оформление заказа";
include "./../hedFot/header.php";
include '../../database/function/connect.php';

$availableAddresses = include 'components/addresses.php';


$courierStmt = $conn->prepare("SELECT courier_id FROM couriers WHERE status = 'Свободен' LIMIT 1");
$courierStmt->execute();
$courierResult = $courierStmt->get_result();
$hasAvailableCourier = $courierResult->num_rows > 0;
$courierStmt->close();

if (isset($_GET['products']) && isset($_GET['total'])) {
	$products = json_decode($_GET['products'], true);
	$totalPrice = (float) $_GET['total'];
	$userId = $_SESSION['user_id'];
	$number = uniqid();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		include 'components/processBuy.php';
		exit;
	}
} else {
	echo "Нет данных для оформления заказа.";
	include "./../hedFot/footer.php";
	exit;
}
?>

<script>
	const availableAddresses = <?php echo json_encode($availableAddresses); ?>;
	let basePrice = <?php echo $totalPrice; ?>;
	let initialDeliveryCost = 50;
	const hasAvailableCourier = <?php echo $hasAvailableCourier ? 'true' : 'false'; ?>;

	document.addEventListener('DOMContentLoaded', function () {
		const totalPriceElement = document.getElementById('totalPrice');
		if (totalPriceElement) {
			totalPriceElement.textContent = `Общая сумма: ${basePrice + initialDeliveryCost} руб.`;
		}

		const submitButton = document.querySelector('input[type="submit"]');
		const formMessage = document.getElementById('form-message');

		if (!hasAvailableCourier) {
			if (submitButton) {
				submitButton.disabled = true;
				submitButton.style.backgroundColor = '#ccc';
				submitButton.style.cursor = 'not-allowed';
			}
			if (formMessage) {
				formMessage.textContent = 'Подождите, все курьеры заняты';
				formMessage.style.display = 'block';
			}
		}
	});
</script>
<script src="./js/buy.js"></script>

<?php
include 'components/formBuy.php';
include "./../hedFot/footer.php";
$conn->close();
?>