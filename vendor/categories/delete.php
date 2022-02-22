<?php
session_start();

require_once '../../includes/db.php';

$id = $_GET['id'];

$query = "DELETE FROM `categories` WHERE (`id` = '$id')";
$response = mysqli_query($db, $query);

if ($response) {
    unset($_SESSION['message']);

    header('Location: /admin/categories/index.php');
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Delete category error'
    ];

    header('Location: /admin/categories/index.php');
}