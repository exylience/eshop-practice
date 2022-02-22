<?php
session_start();

require_once '../../includes/db.php';

$name = $_POST['name'];

$query = "INSERT INTO `categories` (`id`, `name`) VALUES (NULL, '$name')";
$response = mysqli_query($db, $query);

if ($response) {
    unset($_SESSION['validation']);
    unset($_SESSION['message']);

    header('Location: /admin/categories/index.php');
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Category create error'
    ];

    header('Location: /admin/categories/add.php');
}