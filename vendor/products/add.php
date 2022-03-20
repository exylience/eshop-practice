<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$categoryId = $_POST['category_id'];
$path = null; // путь до изображения, по умолчанию null(пустой)

print_r($_FILES['image']);

// если картинка была загружена
if (isset($_FILES['image'])) {
    // генерируем ей уникальное имя
    $fileName = time() . '_' . $_FILES['image']['name'];
    // получаем временный путь картинки на сервере
    $tmpFile = $_FILES['image']['tmp_name'];
    // задаем полный путь
    $path = "uploads/{$fileName}";
    // перемещаем картинку по заданному пути
    move_uploaded_file($tmpFile, "../../$path");
}

// составляем запрос на добавление записи в таблицу
$query = "INSERT INTO `products` (`id`, `title`, `description`, `image_url`, `price`, `category_id`) VALUES 
    (NULL, '$title', '$description', '$path', '$price', '$categoryId')";
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
        'text' => 'Product create error'
    ];

    // возвращаем пользователя назад
    header('Location: /admin/products/add.php');
}
