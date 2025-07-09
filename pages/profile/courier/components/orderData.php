<?php
$ordersQuery = $conn->query("
    SELECT da.number, da.status, da.application_id, da.user_id, da.address, da.products, da.price, da.delivery_time, da.courier_id, c.full_name AS courier_name
    FROM delivery_application da
    LEFT JOIN couriers c ON da.courier_id = c.courier_id
    WHERE da.status != 'Доставлен'
    ORDER BY da.number DESC
");

$orders = [];
while ($row = $ordersQuery->fetch_assoc()) {
	$orders[] = $row;
}
?>