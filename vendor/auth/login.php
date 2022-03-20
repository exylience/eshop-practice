<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем данные из формы
$email = $_POST['email'];
$password = $_POST['password'];

// составляем запрос на выборку пользователей с такой же почтой и паролем
$query = "SELECT * FROM `users` WHERE (`email` = '$email' AND `password` = '$password')";
// выполняем запрос
$response = mysqli_query($db, $query);

// проверяем, вернулись ли хоть какие-нибудь записи из таблицы
if (mysqli_num_rows($response) > 0) {
    // если да, то парсим данные пользователя в ассоциативный массив
    $user = mysqli_fetch_assoc($response);

    // заносим пользователя в сессию
    $_SESSION['user'] = [
        'id' => $user['id'],
        'firstName' => $user['first_name'],
        'lastName' => $user['last_name'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'country' => $user['country'],
        'address' => $user['address'],
        'additionalAddress' => $user['additional_address'],
        'postIndex' => $user['post_index'],
        'group' => (int)$user['user_group']
    ];

    // переходим на главную
    header('Location: /index.php');
} else { // если совпадений не нашлось
    // заносим в сессию ошибку
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Incorrect login or password'
    ];

    // возвращаем пользователя назад
    header('Location: /login.php');
}