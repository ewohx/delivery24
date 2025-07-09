document.addEventListener('DOMContentLoaded', function () {
	if (window.innerWidth <= 768) {
		const notification = document.querySelector('.notification-dropdown');
		const profileDropdown = document.querySelector(
			'.nav-item.dropdown .dropdown-menu'
		);

		if (notification && profileDropdown) {
			profileDropdown.appendChild(notification);
		}
	}
});

function toggleNotificationDropdown() {
	const dropdown = document.querySelector(
		'.notification-dropdown .dropdown-menu'
	);
	dropdown.classList.toggle('show');

	if (dropdown.classList.contains('show')) {
		fetch('?action=mark_notifications_read', {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
			},
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					if (notificationCount) {
						notificationCount.remove();
					}

					const unreadItems = document.querySelectorAll(
						'.notification-menu .dropdown-item.unread'
					);
					unreadItems.forEach(item => item.classList.remove('unread'));
				}
			});
	}
}
