<?php

namespace App\Core\Controller;

class Turmas extends Controller{

    public function index(){
        $turmaModel = $this->model("Turma");

        $turma = $turmaModel->listarTodos();

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
            http_response_code(201);
            echo json_encode($turmaModel);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir preco"]);
        }
    }

    public function update(){
        
        $turmaAtualizada = $this->getRequestBody();
        $id = $turmaAtualizada->id;
        $turmaModel = $this->model("Turma");

        $turma = $turmaModel->buscarPorId($id);

        $turma->nome = $turmaAtualizada->nome;
        $turma->numAlunos = $turmaAtualizada->num_alunos;

        if (!$turma) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }
        
        $turma->atualizar($id);
        //http_response_code(201);
        echo json_encode($turma, JSON_UNESCAPED_UNICODE);
    }

    public function delete(){

        $turmaDeletada= $this->getRequestBody();
        $id = $turmaDeletada->id;
        $turmaModel = $this->model("Turma");

        $turma = $turmaModel->buscarPorId($id);

        if (!$turma) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }

        $turmaModel->deletar($id);
        //http_response_code(201);
        echo json_encode($turma, JSON_UNESCAPED_UNICODE);
    }

}