<?php

namespace App\Services;

use App\Core\Model;
use \App\Core\Service;
use GuzzleHttp\Client;

class CidadaoService extends Service {

    public function index()
    {
        $cidadaoModel = $this->model("Cidadao");
        $cidadoes = $cidadaoModel->buscarTodosCidadoes();
        echo json_encode($cidadoes, JSON_UNESCAPED_UNICODE);
    }

    public function findByCpf($cpf)
    {
        $cidadaoModel = $this->model("Cidadao");
        $cidadao = $cidadaoModel->buscarCidadaoPorCpf($cpf);
        echo json_encode($cidadao, JSON_UNESCAPED_UNICODE);
    }

    public function insert()
    {
        $data = $this->getRequestBody();

        try {
            Model::getConn()->beginTransaction();

            $cidadaoModel = $this->model("Cidadao");

            $checkCpf = $cidadaoModel->buscarCidadaoPorCpf($this->deixarSomenteDigitos($data->nro_cpf));

            if (!empty($checkCpf)) {
                throw new \Exception("Cpf já cadastrado");
            }

            $cidadaoModel->txtNome = $data->txt_nome;
            $cidadaoModel->txtSobrenome = $data->txt_sobrenome;
            $cidadaoModel->nroCpf = $this->deixarSomenteDigitos($data->nro_cpf);

            $contatoModel = $this->model("Contato");
            $contatoModel->txtEmail = $data->txt_email;
            $contatoModel->nroCelular = $data->nro_celular;
            $contato = $contatoModel->inserir();


            $clientGuzzle = new Client();
            $url = "https://viacep.com.br/ws/{$data->nro_cep}/json/";
            $response = $clientGuzzle->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Error ao consultar CEP");
            }

            $respLogra = json_decode($response->getBody()->__toString());

            $enderecoModel = $this->model("Endereco");
            $enderecoModel->nroCep = $respLogra->cep;
            $enderecoModel->txtLogradouro = $respLogra->logradouro;
            $enderecoModel->txtBairro = $respLogra->bairro;
            $enderecoModel->txtCidade = $respLogra->localidade;
            $enderecoModel->txtUf = $respLogra->uf;
            $endereco = $enderecoModel->inserir();

            $cidadaoModel->contatoId = $contato->id;
            $cidadaoModel->enderecoId = $endereco->id;
            $cidadaoModel->inserir();

            if ($cidadaoModel) {
                Model::getConn()->commit();
                http_response_code(201);
                echo json_encode($cidadaoModel);exit;
            }


        } catch (\Exception $e) {
            Model::getConn()->rollBack();
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir Cidadão", "message" => $e->getMessage()]);
        }
    }

    public function deixarSomenteDigitos($input) {
        return preg_replace('/[^0-9]/', '', $input);
    }

}




