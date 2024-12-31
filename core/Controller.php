<?php

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        require_once  __DIR__ . "/../app/views/{$view}.php";
    }

    public function redirect($route)
    {
        header("Location: /ecommerce_mvc/{$route}");
        exit;
    }
}
