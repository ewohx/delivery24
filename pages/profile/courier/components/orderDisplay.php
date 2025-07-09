<main>
	<div class="container">
		<div class="flex-container">
			<div class="orders-list">
				<h2 class="registration-title">Информация о заказах</h2>
				<?php if (!empty($orders)): ?>
					<div class="orders">
						<?php foreach ($orders as $order): ?>
							<div class="order">
								<h3>Заказ №<?= htmlspecialchars($order['number']) ?></h3>
								<p>Статус: <?= htmlspecialchars($order['status']) ?></p>
								<p>Адрес: <?= htmlspecialchars($order['address']) ?></p>

								<?php
								$products = json_decode($order['products'], true);
								$productList = [];
								foreach ($products as $item) {
									$productId = $item['product_id'];
									$quantity = $item['quantity'];

									$stmt = $conn->prepare("SELECT name FROM products WHERE product_id = ?");
									$stmt->bind_param("i", $productId);
									$stmt->execute();
									$res = $stmt->get_result();
									if ($res->num_rows > 0) {
										$p = $res->fetch_assoc();
										$productList[] = $p['name'] . " ({$quantity} шт)";
									}
									$stmt->close();
								}
								?>
								<p>Товары: <?= htmlspecialchars(implode(', ', $productList)) ?></p>
								<p>Цена: <?= htmlspecialchars($order['price']) ?>	руб.</p>
								<p>Время доставки: <?= htmlspecialchars($order['delivery_time']) ?></p>
								<p>Курьер:
									<?= $order['courier_id'] ? htmlspecialchars($order['courier_name']) : "Не назначен" ?>
								</p>

								<?php if ($userRole === 'Курьер' && is_null($order['courier_id']) && $order['status'] === 'Создан'): ?>
									<form method="POST">
										<input type="hidden" name="application_id" value="<?= $order['application_id'] ?>">
										<button type="submit" class='button-reg' name="take_order">Взять заказ</button>
									</form>
								<?php endif; ?>

								<?php if ($userRole === 'Курьер' && $order['courier_id'] == $courierId): ?>
									<form method="POST" style="margin-top:10px;">
										<input type="hidden" name="application_id" value="<?= $order['application_id'] ?>">
										<label for="new_status">Изменить статус:</label>
										<select name="new_status" required>
											<?php foreach ($statuses as $status): ?>
												<?php if ($status !== 'Создан'): ?>
													<option value="<?= $status ?>" <?= $status === $order['status'] ? 'selected' : '' ?>>
														<?= $status ?>
													</option>
												<?php endif; ?>
											<?php endforeach; ?>
										</select>
										<button type="submit" class='button-reg' name="update_status">Обновить</button>
									</form>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<p class='error-message'>Заказов нет</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</main>