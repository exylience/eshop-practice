<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем данные из формы
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['password_confirmation'];
$country = $_POST['country'];
$address = $_POST['first_address'];
$additionalAddress = $_POST['second_address'];
$postIndex = $_POST['post_index'];

// проверяем пароли на совпадение
if ($password === $passwordConfirmation) {
    // составляем запрос на добавление записи в таблицу
    $query = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `country`, `address`, `additional_address`, `post_index`) VALUES
        (NULL, '$firstName', '$lastName', '$email', '$phone', '$password', '$country', '$address', '$additionalAddress', '$postIndex')
    ";
    // выполняем запрос
    $response = mysqli_query($db, $query);

    // если запрос успешно выполнен
    if ($response) {
        // удаляем из сессии все сообщения об ошибках
        unset($_SESSION['validation']);
        unset($_SESSION['message']);

        // переносим пользователя на другую страницу
        header('Location: /login.php');
    } else {
        // иначе добавляем в сессию сообщение об ошибке
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Register error'
        ];

        // возвращаем пользователя назад
        header('Location: /register.php');
    }
} else { // если пароли не совпадают
    // добавляем в сессию сообщение об ошибке
    $_SESSION['validation'] = [
        'password' => 'Passwords do not match',
        'passwordConfirmation' => 'Passwords do not match'
    ];

    // возвращаем пользователя назад
    header('Location: /register.php');
}