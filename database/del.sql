CREATE DATABASE del;

USE del;

CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    role ENUM('Администратор', 'Пользователь', 'Курьер') NOT NULL
);

CREATE TABLE couriers (
    courier_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    status ENUM('Свободен', 'Занят', 'Недоступен') DEFAULT 'Свободен',
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

INSERT INTO `user` (`user_id`, `login`, `email`, `phone`, `password`, `role`) VALUES
(1, 'admin', 'email@email', '+7(932)-234-24-23', 'admin', 'Администратор'),
(2, 'courier1', 'courier1@email.com', '+7(999)-123-45-67', 'courier1', 'Курьер');


INSERT INTO couriers (user_id, full_name, phone, status)
VALUES (2, 'Иванов Иван Иванович', '+7(999)-123-45-67', 'Свободен');

CREATE TABLE delivery_application (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    number VARCHAR(20) NOT NULL,
    status ENUM('Создан', 'Собирается', 'Скоро будем у вас', 'Доставлен') NOT NULL,
    address VARCHAR(255) NOT NULL,
    products TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    delivery_time DATETIME NOT NULL,
    payment_method ENUM('Наличными', 'Картой при получении') NOT NULL,
    delivery_method ENUM('Обычная', 'Элитная') NOT NULL,
    delivery_cost DECIMAL(10, 2) NOT NULL,
    courier_id INT,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (courier_id) REFERENCES couriers(courier_id) ON DELETE SET NULL
);

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE user_questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    question_text TEXT NOT NULL,
    response_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    response_created_at TIMESTAMP, 
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL
);

INSERT INTO products (product_id, name, price, image, category) VALUES
(1, 'Молоко 1л', 85, 'milk.png', 'Молочные продукты'),
(2, 'Туалетная бумага 4шт', 75, 'paper.png', 'Хозтовары'),
(3, 'Спички 4шт', 60, 'matches.png', 'Хозтовары'),
(4, 'Яблоки 1кг', 160, 'apples.png', 'Фрукты'),
(5, 'Огурцы 1кг', 180, 'cucumbers.png', 'Овощи'),
(6, 'Гречка ядрица 1кг', 40, 'buckwheat.png', 'Крупы'),
(7, 'Батон 400г', 40, 'bread.png', 'Хлебобулочные изделия'),
(8, 'Яйцо куриное C1 10 шт', 120, 'egg.png', 'Яйца'),
(9, 'Свинина 1кг', 400, 'meat.png', 'Мясо'),
(10, 'Минтай тихоокеанский 400 г', 400, 'fish.png', 'Рыба'),
(11, 'Помидоры 1кг', 210, 'tomato.png', 'Овощи'),
(12, 'Рис длиннозёрный 900г', 95, 'rice.png', 'Крупы');

CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    timestamp DATETIME NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE stores (
    store_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    phone VARCHAR(20),
    logo VARCHAR(255)
);

INSERT INTO stores (name, address, phone, logo) VALUES
('paterochka', 'ул. Победы, 96', '+7(999)555-66-77', 'pyaterochka.svg');


ALTER TABLE products ADD COLUMN store_id INT NOT NULL DEFAULT 1;


ALTER TABLE products
ADD CONSTRAINT fk_products_store
FOREIGN KEY (store_id) REFERENCES stores(store_id) ON DELETE CASCADE;