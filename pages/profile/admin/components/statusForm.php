<form method="POST" action="">
	<label for="order_number">Выберите номер заказа:</label>
	<select name="order_number" required>
		<?php foreach ($orders as $order): ?>
			<?php if ($order['status'] !== 'Доставлен'): ?>
				<option value="<?php echo $order['number']; ?>">
					Заказ №<?php echo $order['number']; ?>	- Статус: <?php echo $order['status']; ?>
				</option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>

	<label for="status">Выберите новый статус:</label>
	<select name="status" required>
		<?php foreach ($statuses as $status): ?>
			<option value="<?php echo $status; ?>"><?php echo $status; ?></option>
		<?php endforeach; ?>
	</select>

	<button type="submit" class='button-reg'>Обновить статус</button>
</form>