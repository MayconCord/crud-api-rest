<?php

use App\Core\Model;

class Aluno{

    public $id;
    public $nome;
    public $idade;
    public $turma;

    public function listarTodos(){
        $sql = " SELECT * FROM aluno ORDER BY id DESC ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultado;
        } else {
            return [];
        }
    }

    public function inserir(){
        $sql = " INSERT INTO aluno (nome, idade, turma) VALUES (?, ?, ?) ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nome);
        $stmt->bindValue(2, $this->idade);
        $stmt->bindValue(3, $this->turma);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }
    }

    public function buscarPorId($id){
        $sql = " SELECT * FROM aluno WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $aluno = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$aluno) {
                return null;
            }

            $this->id = $aluno->id;
            $this->nome = $aluno->nome;
            $this->idade = $aluno->idade;
            $this->turma = $aluno->turma;


            return $this;
        } else {
            return null;
        }
    }

    public function atualizar(){
        $sql = " UPDATE aluno SET nome = ?, idade = ?, turma = ? WHERE id = ? ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nome); 
        $stmt->bindValue(2, $this->idade);
        $stmt->bindValue(3, $this->turma);
        $stmt->bindValue(4, $this->id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $consultaDelete = 'DELETE FROM aluno WHERE id = :id';
        if ($id) {
            $stmt = Model::getConn()->prepare($consultaDelete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
}