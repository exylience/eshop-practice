<?php
session_start();
require_once '../../includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM `users` WHERE (`email` = '$email' AND `password` = '$password')";
$response = mysqli_query($db, $query);

if (mysqli_num_rows($response) > 0) {
    $user = mysqli_fetch_assoc($response);

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
        'group' => $user['user_group']
    ];

    header('Location: /index.php');
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Incorrect login or password'
    ];

    header('Location: /login.php');
}