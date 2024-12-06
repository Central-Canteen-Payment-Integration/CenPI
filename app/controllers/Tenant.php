<?php

class Tenant extends Controller {
    public function index() {
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/index');
    }
    public function orderlist() {
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/orderlist');
    }

    public function menu() {
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/crudmenu');
    }

    public function historytransaction() {
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/historytransaction');
    }

    public function report() {
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/report');
    }

    public function settings() {
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/settings');
    }
}