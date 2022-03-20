<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем id категории из GET параметра
$id = $_GET['id'];

// составляем запрос на удаление записи из таблицы
$query = "DELETE FROM `categories` WHERE (`id` = '$id')";
// выполняем запрос
$response = mysqli_query($db, $query);

// если запрос успешно выполнен
if ($response) {
    // удаляем из сессии все сообщения об ошибках
    unset($_SESSION['validation']);
    unset($_SESSION['message']);

    // переносим пользователя на другую страницу
    header('Location: /admin/categories/index.php');
} else { // иначе
    // добавляем в сессию сообщение об ошибке
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Category delete error'
    ];

    // возвращаем пользователя назад
    header('Location: /admin/categories/index.php');
}