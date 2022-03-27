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
}