<?php

use Jenssegers\Blade\Blade;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;

/**
 * Class SafeContainer
 * Mục đích: Fix lỗi "Call to undefined method ...::terminating()"
 */
class SafeContainer extends Container
{
    public function terminating($callback)
    {
        return $this;
    }
}

class Controller
{
    public function view(string $view, array $data = []): void
    {
        // 1. Chuẩn hoá tên view
        $normalizedView = $this->normalizeViewName($view);

        // 2. Kiểm tra file tồn tại (Hỗ trợ cả .blade.php và .php)
        $viewPath = str_replace('.', '/', $normalizedView);
        $candidates = [
            VIEW_PATH . '/' . $viewPath . '.blade.php',
            VIEW_PATH . '/' . $viewPath . '.blade',
            VIEW_PATH . '/' . $viewPath . '.php',
        ];

        $found = false;
        foreach ($candidates as $file) {
            if (is_file($file)) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Hiển thị lỗi rõ ràng hơn để debug
            throw new RuntimeException("View file not found. Looked for: " . implode(', ', $candidates));
        }

        // 3. Tạo thư mục cache
        $cachePath = BASE_PATH . '/storage/cache';
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        // 4. Khởi tạo Container thủ công
        $container = new SafeContainer();
        
        // Quan trọng: Đặt container này làm Global để Laravel Facades nhận diện
        Container::setInstance($container);

        // 4a. Đăng ký dịch vụ 'files' (Bắt buộc)
        $container->singleton('files', function () {
            return new Filesystem;
        });

        // 4b. Đăng ký dịch vụ 'events' (Bắt buộc)
        $container->singleton('events', function () {
            return new Dispatcher;
        });

        // LƯU Ý: KHÔNG đăng ký dịch vụ 'config' ở đây nữa.
        // Để thư viện Blade tự động nạp cấu hình đường dẫn từ tham số bên dưới.

        // 5. Khởi tạo Blade
        // Blade sẽ tự động dùng $container chúng ta tạo và điền config vào đó
        $blade = new Blade(VIEW_PATH, $cachePath, $container);

        // 6. Render
        echo $blade->render($normalizedView, $data);
    }

    protected function normalizeViewName(string $view): string
    {
        $view = trim($view);
        $view = str_replace(['\\', '/'], '.', $view);
        $view = preg_replace('/\.+/', '.', $view);
        return trim($view, '.');
    }

    public function model($name)
    {
        $class = ucfirst($name);
        $nsClass = "App\\Models\\" . $class;
        
        if (class_exists($nsClass)) return new $nsClass();
        if (class_exists($class)) return new $class();
        
        throw new Exception("Model $name not found");
    }

    public function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}