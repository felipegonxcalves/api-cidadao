<?php

use \App\Core\Model;

class Endereco {
    public $id;
    public $nroCep;
    public $txtLogradouro;
    public $txtBairro;
    public $txtCidade;
    public $txtUf;

    public function inserir()
    {
        $sql = "INSERT INTO endereco (nro_cep, txt_logradouro, txt_bairro, txt_cidade, txt_uf) VALUES (?, ?, ?, ?, ?)";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nroCep);
        $stmt->bindValue(2, $this->txtLogradouro);
        $stmt->bindValue(3, $this->txtBairro);
        $stmt->bindValue(4, $this->txtCidade);
        $stmt->bindValue(5, $this->txtUf);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }

    }
}
