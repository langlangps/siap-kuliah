<?php

class Application
{
    private $controller = "Home";
    private $method = "index";
    private $parameters = [];

    public function __construct()
    {

        $url = $this->url_parse();

        // ROUTING
        // Mencari Controller

        if (file_exists('../app/controllers/' . $url[0] . ".php")) {
            $this->controller = $url[0];
        }
        unset($url[0]);


        require_once '../app/controllers/' . $this->controller . ".php";
        $this->controller = new $this->controller;

        // Mencari Method

        if (!empty($url)) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
            }
            unset($url[1]);
        }

        // Mencari parameters
        if (!empty($url)) {
            $this->parameters = array_values($url);
        }
        call_user_func([$this->controller, $this->method], $this->parameters);
    }

    public function url_parse()
    {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            $url = rtrim($url, '/');
            $url = filter_var($url);
            $url = explode("/", $url);


            return $url;
        }
    }
}