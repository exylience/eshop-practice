<?php
/**
 * Параметры подключения к БД
 *
 * (1) - номер аргумента в mysqli_connect()
 *
 * hostname (1) - адрес хоста, если сервер локальный, то localhost (127.0.0.1)
 * username (2) - логин БД
 * password (3) - пароль БД
 * database (4) - имя базы данных
 */
$db = mysqli_connect('localhost', 'root', '', 'shop');

// если подключение не удалось
if (!$db) {
    // завершаем выполнение кода и выводим ошибку
    die('Database connection error');
}