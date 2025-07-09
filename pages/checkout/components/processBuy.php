<?php
// Проверяем, что данные POST есть
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	return;
}

// Повторная проверка наличия свободного курьера
$courierStmt = $conn->prepare("SELECT courier_id FROM couriers WHERE status = 'Свободен' LIMIT 1");
$courierStmt->execute();
$courierResult = $courierStmt->get_result();

if ($courierResult->num_rows === 0) {
	// Нет свободных курьеров
	echo "<script>
        document.getElementById('form-message').textContent = 'Подождите, все курьеры заняты';
        document.getElementById('form-message').style.display = 'block';
    </script>";
	$courierStmt->close();
	exit;
}

$courier = $courierResult->fetch_assoc();
$courierId = $courier['courier_id'];
$courierStmt->close();

$address = $_POST['address'];
$houseNumber = $_POST['houseNumber'];
$apartment = $_POST['apartment'];
$paymentMethod = $_POST['paymentMethod'];
$deliveryMethod = $_POST['deliveryMethod'];

$fullAddress = $address . ', Дом ' . $houseNumber . ', Квартира ' . $apartment;

$productsJson = json_encode($products);
$deliveryMethodLower = mb_strtolower($deliveryMethod, 'UTF-8');

$deliveryTime = date('Y-m-d H:i:s', strtotime(
	$deliveryMethodLower === 'обычная' ? '+30 minutes' : '+15 minutes'
));
$deliveryCost = $deliveryMethodLower === 'обычная' ? 50 : 100;
$totalPriceWithDelivery = $totalPrice + $deliveryCost;

$conn->begin_transaction();

try {
	$stmt = $conn->prepare("
        INSERT INTO delivery_application (
            user_id, number, status, address, products, price, 
            delivery_time, payment_method, delivery_method, delivery_cost, courier_id
        ) VALUES (?, ?, 'Создан', ?, ?, ?, ?, ?, ?, ?, NULL)
    ");
	if ($stmt === false)
		throw new Exception("Ошибка подготовки запроса: " . $conn->error);

	$stmt->bind_param(
		"isssdsssd",
		$userId,
		$number,
		$fullAddress,
		$productsJson,
		$totalPriceWithDelivery,
		$deliveryTime,
		$paymentMethod,
		$deliveryMethod,
		$deliveryCost
	);

	if (!$stmt->execute())
		throw new Exception("Ошибка выполнения запроса: " . $stmt->error);

	// Обновляем статус курьера
	$updateCourierStmt = $conn->prepare("UPDATE couriers SET status = 'Занят' WHERE courier_id = ?");
	$updateCourierStmt->bind_param("i", $courierId);
	if (!$updateCourierStmt->execute())
		throw new Exception("Ошибка обновления статуса курьера: " . $updateCourierStmt->error);

	// Добавляем уведомление
	$notificationStmt = $conn->prepare("
        INSERT INTO notifications (user_id, order_number, status, timestamp, is_read)
        VALUES (?, ?, 'Создан', NOW(), FALSE)
    ");
	$notificationStmt->bind_param("is", $userId, $number);
	if (!$notificationStmt->execute())
		throw new Exception("Ошибка добавления уведомления: " . $notificationStmt->error);

	$conn->commit();

	$_SESSION['order_number'] = $number;
	echo "<script>localStorage.removeItem('cart');</script>";
	header("Location: status.php");
	exit;

} catch (Exception $e) {
	$conn->rollback();
	echo "<script>
        document.getElementById('form-message').textContent = 'Ошибка: " . addslashes($e->getMessage()) . "';
        document.getElementById('form-message').style.display = 'block';
    </script>";
}

$stmt->close();
$updateCourierStmt->close();
$notificationStmt->close();
$conn->close();
?>