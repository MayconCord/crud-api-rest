<?php

use App\Core\Model;

class Turma{

    public $id;
    public $nome;
    public $numAlunos;

    public function listarTodos() {
        $sql = " SELECT * FROM turma ORDER BY id DESC ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultado;
        } else {
            return [];
        }
    }
    
    public function getUltimoInserido(){

        $sql = " SELECT * FROM turma ORDER BY id DESC LIMIT 1 ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);
            return $resultado;
        } else {
            return null;
        }

    }

    public function inserir(){
        $sql = " INSERT INTO turma (nome, num_alunos) VALUES (?, ?) ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nome);
        $stmt->bindValue(2, $this->numAlunos);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }
    }

    public function buscarPorId($id){

        $sql = " SELECT * FROM turma WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $turma = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$turma) {
                return null;
            }

            $this->id = $turma->id;
            $this->nome = $turma->nome;
            $this->numAlunos = $turma->num_alunos;

            return $this;
        } else {
            return null;
        }

    }

    public function atualizar($id){
        $sql = " UPDATE turma SET nome = ?, num_alunos = ? WHERE id = ? ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nome); 
        $stmt->bindValue(2, $this->numAlunos);
        $stmt->bindValue(3, $id);

        return $stmt->execute();
    }

    public function deletar($id) {
        $sql = 'DELETE FROM turma WHERE id = ?';
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindParam(1, $id);

        return $stmt->execute();
    }


}