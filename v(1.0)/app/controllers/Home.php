<?php

class Home extends Controller
{
    public function index()
    {
        $data['title'] = 'SiapKuliah.com';
        $this->view("home/index", $data);
    }
}