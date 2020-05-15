<?php

class Controller
{
    

    public function __construct()
    {
        
    }

    public function view($name, $data = [])
    {
        require_once '../app/views/' . $name . '.php';
    }

    public function getModel($modelName)
    {
        require_once '../app/models/' . $modelName . '.php';
        // Mengembalikan objek model yang diinginkan
        return new $modelName;
    }
}