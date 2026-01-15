<?php 
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');

// Sửa đường dẫn View: Nằm trong APP_PATH/view (dựa trên cấu trúc file bạn gửi)
define('VIEW_PATH', APP_PATH . '/view'); 

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