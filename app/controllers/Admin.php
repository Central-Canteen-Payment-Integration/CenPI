<?php

class Admin extends Controller {
    public function index() {
        $this->view('templates/admin_header');
        $this->view('admin/index');
    }
    public function orderlist() {
        $this->view('templates/admin_header');
        $this->view('admin/orderlist');
    }

    public function orderqueue() {
        $this->view('templates/admin_header');
        $this->view('admin/orderqueue');
    }

    public function menu() {
        $this->view('templates/admin_header');
        $this->view('admin/crudmenu');
    }

    public function historytransaction() {
        $this->view('templates/admin_header');
        $this->view('admin/historytransaction');
    }

    public function report() {
        $this->view('templates/admin_header');
        $this->view('admin/report');
    }

    public function settings() {
        $this->view('templates/admin_header');
        $this->view('admin/settings');
    }
}

?>