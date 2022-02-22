<?php
session_start();

require_once '../../includes/db.php';

$id = $_POST['id'];
$name = $_POST['name'];

$query = "UPDATE `categories` SET `name` = '$name' WHERE (`id` = '$id')";
$response = mysqli_query($db, $query);

if ($response) {
    unset($_SESSION['message']);

    header('Location: /admin/categories/index.php');
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Update category error'
    ];

    header('Location: /admin/categories/edit.php');
}