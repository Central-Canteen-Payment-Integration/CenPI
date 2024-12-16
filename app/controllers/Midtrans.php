<?php

class Midtrans extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }

    public function notification() {
        
    }
}