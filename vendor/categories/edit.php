<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем данные из формы
$id = $_POST['id'];
$name = $_POST['name'];

// составляем запрос на обновление записи в таблице
$query = "UPDATE `categories` SET `name` = '$name' WHERE (`id` = '$id')";
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
        'text' => 'Category update error'
    ];

    // возвращаем пользователя назад
    header("Location: /admin/categories/edit.php?id={$id}");
}