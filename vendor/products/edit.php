<?php
session_start();

require_once '../../includes/db.php';

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$categoryId = $_POST['category_id'];

if (!is_null($_FILES['image'])) {
    $imageName = time() . '_' . $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $path = "uploads/products/{$imageName}";
    move_uploaded_file($tmpName, '../../' . $path);
} else {
    $path = $_POST['image_url'];
}

$query = "UPDATE `products` 
    SET `title` = '$title', `description` = '$description', `price` = '$price', `category_id` = '$categoryId', `image_url` = '$path'
    WHERE (`id` = '$id')";
$response = mysqli_query($db, $query);

if ($response) {
    unset($_SESSION['message']);
    unset($_SESSION['validation']);

    header('Location: /admin/products/index.php');
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Update product error'
    ];

    header('Location: /admin/products/edit.php');
}