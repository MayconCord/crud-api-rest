<?php

namespace App\Core;

class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct(){
        
        $url = $this->parseURL();

        $u = "../Controllers/".ucfirst($url[2]).".php";
        $i = "C:\\xampp\htdocs\arq-rest-php\App\Controllers\\".ucfirst($url[2]).".php";
        var_dump($i);
        var_dump(file_exists($i));

        if(file_exists($i)){

            $this->controller = $url[2];
            unset($url[2]);

        }elseif(empty($url[2])){

            echo "API-REST estacionamento";
            exit;

        }else{
            http_response_code(404);
            echo json_encode(["erro" => "Recurso não encontrado"]);
            exit;
        }

        require_once "C:\\xampp\htdocs\arq-rest-php\App\Controllers\\".ucfirst($this->controller).".php";

        $this->controller = new $this->controller;
        $this->method = $_SERVER["REQUEST_METHOD"];

        switch($this->method){
            case "GET":

                if(isset($url[3])){
                    $this->controllerMethod = "find";
                    $this->params = [$url[3]];
                }else{
                    $this->controllerMethod = "index";
                }
                
                break;

            case "POST":
                $this->controllerMethod = "store";
                break;

            case "PUT":
                $this->controllerMethod = "update";
                if(isset($url[3]) && is_numeric($url[3])){
                    $this->params = [$url[3]];
                }else{
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id"]);
                    exit;
                }
                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                if(isset($url[3]) && is_numeric($url[3])){
                    $this->params = [$url[3]];
                }else{
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id"]);
                    exit;
                }
                break;

            default: 
                echo "Método não suportado";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

}