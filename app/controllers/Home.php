<?php

class Home extends Controller {
    public function index() {
        $data = [
            'page' => 'Home - CenPI',
        ];
        $this->view('templates/init', $data);
        $this->view('home/index');
    }
}
