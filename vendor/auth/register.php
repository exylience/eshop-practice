<?php
session_start();

require_once '../../includes/db.php';

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

if ($password === $passwordConfirmation) {
    $query = "INSERT INTO `users`
        (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `country`, `address`, `additional_address`, `post_index`) VALUES
        (NULL, '$firstName', '$lastName', '$email', '$phone', '$password', '$country', '$address', '$additionalAddress', '$postIndex')
    ";

    $response = mysqli_query($db, $query);

    if ($response) {
        unset($_SESSION['validation']);
        unset($_SESSION['message']);

        header('Location: /index.php');
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Register error'
        ];

        header('Location: /register.php');
    }
} else {
    $_SESSION['validation'] = [
        'password' => 'Passwords do not match',
        'passwordConfirmation' => 'Passwords do not match'
    ];

    header('Location: /register.php');
}