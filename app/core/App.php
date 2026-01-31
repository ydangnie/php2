<?php
class App {
    // SỬA Ở ĐÂY: Đặt mặc định là ViewController và hàm index
    protected $controller = 'ViewController';
    protected $action = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Xử lý Controller
        if (isset($url[0])) {
            if (file_exists('../app/controller/' . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once '../app/controller/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Xử lý Action (Method)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
                unset($url[1]);
            }
        }

        // Xử lý Params
        $this->params = $url ? array_values($url) : [];

        // Gọi hàm
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}