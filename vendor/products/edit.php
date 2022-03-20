<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем данные из формы
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$categoryId = $_POST['category_id'];
$path = $_POST['image_url']; // путь до изображения

// если картинка была загружена
if ((int)$_FILES['image']['error'] === 0) {
    // генерируем ей уникальное имя
    $fileName = time() . '_' . $_FILES['image']['name'];
    // получаем временный путь картинки на сервере
    $tmpFile = $_FILES['image']['tmp_name'];
    // задаем полный путь
    $path = "uploads/{$fileName}";
    // перемещаем картинку по заданному пути
    move_uploaded_file($tmpFile, "../../$path");
}

// составляем запрос на обновление записи в таблице
$query = "UPDATE `products` SET `title` = '$title', `description` = '$description', `price` = '$price', 
    `image_url` = '$path', `category_id` = '$categoryId'
    WHERE (`id` = '$id')
";
// выполняем запрос
$response = mysqli_query($db, $query);

// если запрос успешно выполнен
if ($response) {
    // удаляем из сессии все сообщения об ошибках
    unset($_SESSION['validation']);
    unset($_SESSION['message']);

    // переносим пользователя на другую страницу
    header('Location: /admin/products/index.php');
} else { // иначе
    // добавляем в сессию сообщение об ошибке
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Product update error'
    ];

    // возвращаем пользователя назад
    header("Location: /admin/products/edit.php?id={$id}");
}
