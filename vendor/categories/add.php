<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем данные из формы
$name = $_POST['name'];

// составляем запрос на добавление записи в таблицу
$query = "INSERT INTO `categories` (`id`, `name`) VALUES (NULL, '$name')";
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
        'text' => 'Category create error'
    ];

    // возвращаем пользователя назад
    header('Location: /admin/categories/add.php');
}