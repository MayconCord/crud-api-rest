<?php

use App\Core\Controller;

class Turmas extends Controller{

    public function index(){
        $turmaModel = $this->model("Turma");

        $turma = $turmaModel->getUltimoInserido();

        if (!$turma) {
            http_response_code(204);
            exit;
        }

        echo json_encode($turma, JSON_UNESCAPED_UNICODE);
    }

    public function store(){
        $novaTurma = $this->getRequestBody();

        $turmaModel = $this->model("Turma");
        $turmaModel->nome = $novaTurma->nome;
        $turmaModel->numAlunos = $novaTurma->num_alunos;

        $turmaModel = $turmaModel->inserir();

        if ($turmaModel) {
            http_response_code(201); //created
            echo json_encode($turmaModel);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir preco"]);
        }
    }

    public function update($id){
        $turmaModel = $this->model("Model");

        $turmaModel = $turmaModel->buscarPorId($id);

        if (!$turmaModel) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }

        //$clienteModel = $this->calcularValor($clienteModel);
        
        $turmaModel->atualizar();
        http_response_code(201);
        echo json_encode($turmaModel, JSON_UNESCAPED_UNICODE);
    }

}