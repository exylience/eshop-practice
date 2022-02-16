<?php
$db = mysqli_connect('localhost', 'root', '', 'shop');

if (!$db) {
    die('Database connection error');
}