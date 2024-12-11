<?php 

class Controller {
    public function view($view, $data = []) {
        require_once './app/views/' . $view . '.php';
    }

    public function model($model) {
        require_once './app/models/' . $model . '.php';
        return new $model;
    }

    public function log($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
    }
}