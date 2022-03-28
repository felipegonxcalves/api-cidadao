<?php

use \App\Core\Model;

class Contato {
    public $id;
    public $txtEmail;
    public $nroCelular;

    public function inserir()
    {
        $sql = "INSERT INTO contato (txt_email, nro_celular) VALUES (?, ?)";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->txtEmail);
        $stmt->bindValue(2, $this->nroCelular);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }

    }

    public function getContatoById($id)
    {
        $sql = "SELECT * FROM contato where id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $contato = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$contato){
                return null;
            }

            $this->id = $contato->id;
            $this->txtEmail = $contato->txt_email;
            $this->nroCelular = $contato->nro_celular;

            return $this;
        }

        return null;
    }

    public function update()
    {
        $sql = "UPDATE contato SET txt_email = ?, nro_celular = ? WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->txtEmail);
        $stmt->bindValue(2, $this->nroCelular);
        $stmt->bindValue(3, $this->id);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }

    }
}