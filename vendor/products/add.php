<?php
session_start();

require_once '../../includes/db.php';

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$categoryId = $_POST['category_id'];

$imageName = time() . '_' . $_FILES['image']['name'];
$tmpName = $_FILES['image']['tmp_name'];
$path = "uploads/products/{$imageName}";
move_uploaded_file($tmpName, '../../' . $path);

$query = "INSERT INTO `products` (`id`, `title`, `description`, `price`, `image_url`, `category_id`) VALUES
    (NULL, '$title', '$description', '$price', '$path', '$categoryId')
";
$response = mysqli_query($db, $query);

if ($response) {
    unset($_SESSION['message']);
    unset($_SESSION['validation']);

    header('Location: /admin/products/index.php');
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Product create error'
    ];

    header('Location: /admin/products/add.php');
}