<?php

use App\Core\Controller;

class Alunos extends Controller{

    public function index(){

        $alunoModel = $this->model("Aluno");
        $alunos = $alunoModel->listarTodos();
        echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
    }

    public function store(){

        $novoAluno = $this->getRequestBody();

        $alunoModel = $this->model("Aluno");
        $alunoModel->nome = $novoAluno->nome;
        $alunoModel->idade = $novoAluno->idade;
        $alunoModel->turma = $novoAluno->turma;
        
        //$turmaModel = $this->model("Turma");

        $alunoModel = $alunoModel->inserir();

        if ($alunoModel) {
            http_response_code(201);
            echo json_encode($alunoModel);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir preco"]);
        }

    }

    public function update($id){
        $alunoModel = $this->model("Aluno");

        $alunoModel = $alunoModel->buscarPorId($id);

        if (!$alunoModel) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }

        //$clienteModel = $this->calcularValor($clienteModel);
        
        $alunoModel->atualizar();
        http_response_code(201);
        echo json_encode($alunoModel, JSON_UNESCAPED_UNICODE);
    }

    public function delete($id){
        $alunoModel = $this->model("Aluno");

        $alunoModel = $alunoModel->buscarPorId($id);

        if (!$alunoModel) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }

        //$aluno = $this->calcularValor($clienteModel);
        
        $alunoModel->deletar();
        http_response_code(201);
        echo json_encode($alunoModel, JSON_UNESCAPED_UNICODE);
    }

}