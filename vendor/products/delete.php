<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем id товара из GET параметра
$id = $_GET['id'];

// составляем запрос на удаление записи из таблицы
$query = "DELETE FROM `products` WHERE (`id` = '$id')";
// выполняем запрос
$response = mysqli_query($db, $query);

// если запрос успешно выполнен
if ($response) {
    // удаляем из сессии все сообщения об ошибках
    unset($_SESSION['validation']);
    unset($_SESSION['message']);

    // переносим пользователя на другую страницу
    header('Location: /admin/products/index.php');
} else { // иначе
    // добавляем в сессию сообщение об ошибке
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Product delete error'
    ];

    // возвращаем пользователя назад
    header('Location: /admin/products/index.php');
}