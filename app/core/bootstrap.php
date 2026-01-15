<?php 
// Di chuyển ra ngoài 2 cấp thư mục để lấy thư mục gốc (Project Root)
// app/core -> app -> Root
define('BASE_PATH', dirname(__DIR__, 2));

define('APP_PATH', BASE_PATH . '/app');
// Lưu ý: Nếu thư mục views nằm trong app thì dùng APP_PATH, nếu nằm ngoài thì dùng BASE_PATH
define('VIEW_PATH', BASE_PATH . '/views'); 

// Sửa 'controllers' thành 'controller' để khớp với tên thư mục thực tế
define('CONTROLLER_PATH', APP_PATH . '/controller');
define('MODEL_PATH', APP_PATH. '/models');

spl_autoload_register(function (string $class) {
 $paths = [
    APP_PATH. '/core/' . $class . '.php',
    CONTROLLER_PATH. '/' . $class . '.php',
    MODEL_PATH. '/'. $class . '.php',
 ];

 foreach ($paths as $path){
    if(file_exists($path)){
        require_once $path;
        return;
    }
 }
});