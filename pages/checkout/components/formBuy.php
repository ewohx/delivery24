<main>
	<div class="container">
		<h2 style="text-align: center;">Оформление заказа</h2>
		<div id="form-message" class="error-message" style="display: none;"></div>
		<form
			action="buy.php?products=<?php echo urlencode(json_encode($products)); ?>&total=<?php echo $totalPrice; ?>"
			method="POST" onsubmit="return validateForm()">

			<div class="form-group" style="position: relative;">
				<label for="address">Улица:</label>
				<input type="text" id="address" name="address" oninput="showAddressSuggestions()" autocomplete="off"
					required>
				<div id="address-suggestions" class="suggestions"></div>
			</div>

			<div class="form-group" style="position: relative;">
				<label for="houseNumber">Номер дома:</label>
				<input type="text" id="houseNumber" name="houseNumber" oninput="showHouseSuggestions()"
					autocomplete="off" required>
				<div id="house-suggestions" class="suggestions"></div>
			</div>

			<div class="form-group" style="position: relative;">
				<label for="apartment">Номер квартиры:</label>
				<input type="text" id="apartment" name="apartment" autocomplete="off" required>
			</div>

			<div class="form-group">
				<label for="paymentMethod">Способ оплаты:</label>
				<select id="paymentMethod" name="paymentMethod" required>
					<option value="Наличными">Наличными</option>
					<option value="Картой при получении">Картой при получении</option>
				</select>
			</div>

			<div class="form-group">
				<label for="deliveryMethod">Способ доставки:</label>
				<select id="deliveryMethod" name="deliveryMethod" required onchange="updateDeliveryInfo()">
					<option value="Обычная">Обычная (50 руб / 30 мин)</option>
					<option value="Элитная">Элитная (100 руб / 15 мин)</option>
				</select>
			</div>

			<div id="totalPriceContainer">
				<p id="totalPrice">Общая сумма: <?php echo $totalPrice; ?>	руб.</p>
			</div>

			<input type="submit" value="Оплатить" style="color: black" <?php echo !$hasAvailableCourier ? 'disabled style="background-color:#ccc; cursor:not-allowed;"' : ''; ?>>
		</form>
	</div>
</main>