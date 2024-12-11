<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        if (isset($url[0])){
            if (file_exists('app/controllers/' . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            } else {
                $this->handle404();
                return;
            }
        }

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (isset($url[1]) && method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                $this->handle404();
                return;
            }
        }

        $this->params = $url ? array_values($url) : [];

        try {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } catch (Error $e) {
            if ($e instanceof Error && strpos($e->getMessage(), 'cannot access private method') !== false) {
                $this->handle404();
            } else {
                throw $e;
            }
        }
    }

    private function parseURL() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    private function handle404() {
        http_response_code(404);
        include './app/views/404.php';
        exit();
    }
}