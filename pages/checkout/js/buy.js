function showAddressSuggestions() {
	const input = document.getElementById('address');
	const suggestionsContainer = document.getElementById('address-suggestions');
	const inputValue = input.value.toLowerCase();

	suggestionsContainer.innerHTML = '';

	if (inputValue) {
		const suggestions = Object.keys(availableAddresses).filter(address =>
			address.toLowerCase().includes(inputValue)
		);

		suggestions.forEach(suggestion => {
			const suggestionItem = document.createElement('div');
			suggestionItem.textContent = suggestion;
			suggestionItem.classList.add('suggestion-item');
			suggestionItem.onclick = () => selectAddress(suggestion);
			suggestionsContainer.appendChild(suggestionItem);
		});
	}
}

function selectAddress(address) {
	document.getElementById('address').value = address;
	document.getElementById('address-suggestions').innerHTML = '';
	updateHouses();
}

function showHouseSuggestions() {
	const input = document.getElementById('houseNumber');
	const suggestionsContainer = document.getElementById('house-suggestions');
	const inputValue = input.value;

	suggestionsContainer.innerHTML = '';

	if (inputValue) {
		const selectedAddress = document.getElementById('address').value;
		if (selectedAddress && availableAddresses[selectedAddress]) {
			const suggestions = availableAddresses[selectedAddress].houses.filter(
				house => house.includes(inputValue)
			);

			suggestions.forEach(suggestion => {
				const suggestionItem = document.createElement('div');
				suggestionItem.textContent = suggestion;
				suggestionItem.classList.add('suggestion-item');
				suggestionItem.onclick = () => selectHouse(suggestion);
				suggestionsContainer.appendChild(suggestionItem);
			});
		}
	}
}

function selectHouse(house) {
	document.getElementById('houseNumber').value = house;
	document.getElementById('house-suggestions').innerHTML = '';
}
function updateDeliveryInfo() {
	const deliveryMethod = document
		.getElementById('deliveryMethod')
		.value.toLowerCase();
	const totalPriceElement = document.getElementById('totalPrice');
	let deliveryCost = 0;

	if (deliveryMethod === 'обычная') {
		deliveryCost = 50;
	} else if (deliveryMethod === 'элитная') {
		deliveryCost = 100;
	} else {
		alert('Пожалуйста, выберите корректный способ доставки.');
		return;
	}

	const totalPriceWithDelivery = basePrice + deliveryCost;
	totalPriceElement.textContent = `Общая сумма: ${totalPriceWithDelivery} руб.`;
}

function showMessage(message) {
	const messageElement = document.getElementById('form-message');
	messageElement.textContent = message;
	messageElement.style.display = 'block';
}

function validateForm() {
	if (!hasAvailableCourier) {
		showMessage('Подождите, все курьеры заняты');
		return false;
	}

	const address = document.getElementById('address').value;
	const houseNumber = document.getElementById('houseNumber').value;
	const apartment = document.getElementById('apartment').value;
	const paymentMethod = document.getElementById('paymentMethod').value;
	const deliveryMethod = document.getElementById('deliveryMethod').value;

	document.getElementById('form-message').style.display = 'none';

	if (!availableAddresses[address]) {
		showMessage('Пожалуйста, выберите корректную улицу из предложенных.');
		return false;
	}

	if (!availableAddresses[address].houses.includes(houseNumber)) {
		showMessage(
			'Пожалуйста, выберите корректный номер дома для выбранной улицы.'
		);
		return false;
	}

	if (!/^\d+$/.test(apartment)) {
		showMessage('Номер квартиры должен содержать только цифры.');
		return false;
	}

	if (!paymentMethod) {
		showMessage('Пожалуйста, выберите способ оплаты.');
		return false;
	}

	if (!deliveryMethod) {
		showMessage('Пожалуйста, выберите способ доставки.');
		return false;
	}

	return true;
}
