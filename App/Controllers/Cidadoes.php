<?php

use \App\Core\Controller;

class Cidadoes extends Controller {

    public $cidadao_service;

    public function __construct()
    {
        $this->cidadao_service = new \App\Services\CidadaoService();
    }

    public function index()
    {
        return $this->cidadao_service->index();
    }

    public function store()
    {
        return $this->cidadao_service->insert();
    }

    public function find($param)
    {
        return $this->cidadao_service->findByCpf($param);
    }

    public function update($id)
    {
        return $this->cidadao_service->update($id);
    }
}
