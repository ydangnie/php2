<?php
use Dotenv\Dotenv;

// 1. Định nghĩa đường dẫn
define('BASE_PATH', dirname(__DIR__, 2)); // Đường dẫn tới thư mục gốc (php11)
define('APP_PATH', BASE_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controller'); // Chú ý: controller (số ít)
define('MODEL_PATH', APP_PATH . '/models');

// 2. Load Composer Autoload (BẮT BUỘC CHẠY ĐẦU TIÊN)
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
} else {
    die("Vui lòng chạy lệnh 'composer install' tại thư mục gốc.");
}

// 3. Load file .env
// Thử tìm file .env trong thư mục 'app' trước, nếu không thấy thì tìm ở 'root'
try {
    if (file_exists(APP_PATH . '/.env')) {
        $dotenv = Dotenv::createImmutable(APP_PATH);
        $dotenv->safeLoad();
    } elseif (file_exists(BASE_PATH . '/.env')) {
        $dotenv = Dotenv::createImmutable(BASE_PATH);
        $dotenv->safeLoad();
    }
} catch (Exception $e) {
    // Bỏ qua lỗi nếu không load được .env
}

// 4. Autoload cho các class MVC cũ (nếu chưa có namespace)
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/core/' . $class . '.php',
        CONTROLLER_PATH . '/' . $class . '.php',
        MODEL_PATH . '/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});