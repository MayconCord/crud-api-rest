<?php

namespace App\Core;

class Controller
{

    public function model($model)
    {
        require_once "C:\\xampp\htdocs\arq-rest-php\App\Models\\".$model.".php";        
        return new $model;
    }

    protected function getRequestBody()
    {
        $json = file_get_contents("php://input");
        $obj = json_decode($json);

        return $obj;
    }
}
