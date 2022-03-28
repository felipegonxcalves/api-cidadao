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

    public function getEnderecoById($id)
    {
        $sql = "SELECT * FROM endereco WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $endereco = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$endereco){
                return null;
            }

            $this->id = $endereco->id;
            $this->nroCep = $endereco->nro_cep;
            $this->txtLogradouro = $endereco->txt_logradouro;
            $this->txtBairro = $endereco->txt_bairro;
            $this->txtCidade = $endereco->txt_cidade;
            $this->txtUf = $endereco->txt_uf;

            return $this;
        }

        return null;
    }

    public function update()
    {
        $sql = "UPDATE endereco SET nro_cep = ?, txt_logradouro = ?, txt_bairro = ?, txt_cidade = ?, txt_uf = ? WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nroCep);
        $stmt->bindValue(2, $this->txtLogradouro);
        $stmt->bindValue(3, $this->txtBairro);
        $stmt->bindValue(4, $this->txtCidade);
        $stmt->bindValue(5, $this->txtUf);
        $stmt->bindValue(6, $this->id);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }
    }
}
