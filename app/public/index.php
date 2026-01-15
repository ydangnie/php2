<?php
// dirname(__DIR__) trả về thư mục 'app'. File bootstrap nằm trong 'app/core'.
require_once dirname(__DIR__) . '/core/bootstrap.php';

$router = new Router();
$router->dispatch($_SERVER["REQUEST_URI"]);
?>