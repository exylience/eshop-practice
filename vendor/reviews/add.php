<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once 'includes/db.php';

// получаем данные из формы
$productId = $_POST['product_id'];
$userId = $_POST['user_id'];
$message = $_POST['message'];
$stars = $_POST['stars'];

// составляем запрос на добавление записи в таблицу
$query = "INSERT INTO `reviews` 
    (`id`, `message`, `user_id`, `product_id`, `stars`) VALUES
    (NULL, '$message', '$userId', '$productId', '$stars')";
// выполняем запрос
$response = mysqli_query($db, $query);

// если запрос успешно выполнен
if ($response) {
    // удаляем из сессии все сообщения об ошибках
    unset($_SESSION['message']);
    unset($_SESSION['validation']);

    // возвращаем пользователя назад
    header("Location: /product-details.php?id={$productId}");
} else { // иначе
    // добавляем в сессию сообщение об ошибке
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Review create error'
    ];

    // возвращаем пользователя назад
    header("Location: /product-details.php?id={$productId}");
}