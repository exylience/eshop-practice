<?php
session_start();

require_once '../../includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM `users` WHERE (`email` = '$email' AND `password` = '$password')";
$response = mysqli_query($db, $query);

if (mysqli_num_rows($response) === 0) {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Incorrect login or password'
    ];

    header('Location: /login.php');
} else {
    $result = mysqli_fetch_assoc($response);

    $_SESSION['user'] = [
        'id' => $result['id'],
        'firstName' => $result['first_name'],
        'lastName' => $result['last_name'],
        'email' => $result['email'],
        'phone' => $result['phone'],
        'country' => $result['country'],
        'address' => $result['address'],
        'additionalAddress' => $result['additional_address'],
        'postIndex' => $result['post_index'],
        'group' => (int)$result['user_group']
    ];

    unset($_SESSION['message']);
    unset($_SESSION['validation']);

    header('Location: /index.php');
}