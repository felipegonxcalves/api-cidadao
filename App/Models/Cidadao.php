<?php

use App\Core\Model;

class Cidadao {
    public $id;
    public $txtNome;
    public $txtSobrenome;
    public $nroCpf;
    public $contatoId;
    public $enderecoId;

    public function buscarTodosCidadoes()
    {
        $sql = "SELECT c.id as id_contato,
                       c.txt_nome,
                       c.txt_sobrenome,
                       c.nro_cpf,
                       ct.txt_email,
                       ct.nro_celular,
                       e.nro_cep,
                       e.txt_logradouro,
                       e.txt_bairro,
                       e.txt_cidade,
                       e.txt_uf
                FROM cidadao c
                INNER JOIN contato ct ON ct.id = c.contato_id
                INNER JOIN endereco e ON e.id = c.endereco_id
                ORDER BY c.txt_nome ASC ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultado;
        } else {
            return null;
        }
    }

    public function buscarCidadaoPorCpf($cpf)
    {
        $sql = "SELECT * FROM cidadao WHERE nro_cpf = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $cpf);

        if ($stmt->execute()) {
            $cidadao = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$cidadao){
                return null;
            }

            $this->id = $cidadao->id;
            $this->txtNome = $cidadao->txt_nome;
            $this->txtSobrenome = $cidadao->txt_sobrenome;
            $this->nroCpf = $cidadao->nro_cpf;
            $this->contatoId = $cidadao->contato_id;
            $this->enderecoId = $cidadao->endereco_id;

            return $this;
        }

        return null;
    }

    public function inserir()
    {
        $sql = "INSERT INTO cidadao (txt_nome, txt_sobrenome, nro_cpf, contato_id, endereco_id) VALUES (?, ?, ?, ?, ?)";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->txtNome);
        $stmt->bindValue(2, $this->txtSobrenome);
        $stmt->bindValue(3, $this->nroCpf);
        $stmt->bindValue(4, $this->contatoId);
        $stmt->bindValue(5, $this->enderecoId);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        }

        return ['errorMessage' => $stmt->errorInfo()];
    }

    public function getCidadaoById($id)
    {
        $sql = "SELECT * FROM cidadao where id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $cidadao = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$cidadao){
                return null;
            }

            $this->id = $cidadao->id;
            $this->txtNome = $cidadao->txt_nome;
            $this->txtSobrenome = $cidadao->txt_sobrenome;
            $this->nroCpf = $cidadao->nro_cpf;
            $this->contatoId = $cidadao->contato_id;
            $this->enderecoId = $cidadao->endereco_id;

            return $this;
        }

        return null;
    }

    public function update()
    {
        $sql = "UPDATE cidadao SET txt_nome = ?, txt_sobrenome = ?, nro_cpf = ? WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->txtNome);
        $stmt->bindValue(2, $this->txtSobrenome);
        $stmt->bindValue(3, $this->nroCpf);
        $stmt->bindValue(4, $this->id);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }
    }

}
