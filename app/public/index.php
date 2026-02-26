<?php
session_start();
// dirname(__DIR__) trả về thư mục 'app'. File bootstrap nằm trong 'app/core'.
require_once dirname(__DIR__) . '/core/bootstrap.php';

// LOAD BIẾN MÔI TRƯỜNG TRƯỚC
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)); // Trỏ vào thư mục app
$dotenv->safeLoad();

// SAU ĐÓ MỚI CHẠY ROUTER ĐIỀU HƯỚNG
$router = new Router();
$router->dispatch($_SERVER["REQUEST_URI"]);
?>