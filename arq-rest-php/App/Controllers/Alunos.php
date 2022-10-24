<?php

namespace App\Core\Controller;

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

    public function update(){

        $alunoAtualizado = $this->getRequestBody();
        $id = $alunoAtualizado->id;

        $alunoModel = $this->model("Aluno");
        $aluno = $alunoModel->buscarPorId($id);

        $aluno->nome = $alunoAtualizado->nome;
        $aluno->idade = $alunoAtualizado->idade;
        $aluno->turma = $alunoAtualizado->turma;

        if (!$aluno) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }
        
        $aluno->atualizar($id);
        http_response_code(201);
        echo json_encode($aluno, JSON_UNESCAPED_UNICODE);
    }

    public function delete(){

        $alunoDeletado = $this->getRequestBody();
        $id = $alunoDeletado->id;

        $alunoModel = $this->model("Aluno");

        $aluno = $alunoModel->buscarPorId($id);

        if (!$aluno) {
            http_response_code(404);
            echo json_encode(["erro" => "cliente não encontrado"]);
            exit;
        }

        $alunoModel->deletar($id);
        //http_response_code(201);
        echo json_encode($alunoModel, JSON_UNESCAPED_UNICODE);
    }

}