# api-cidadao
DESAFIO - Desenvolvimento de API em PHP para manipular dados de cidadão.

Criar database:

create database api_cidadao;

use api_cidadao;

CREATE TABLE cidadao (
	id INT PRIMARY KEY AUTO_INCREMENT,
    txt_nome VARCHAR(255) NOT NULL,
    txt_sobrenome VARCHAR(200) NOT NULL,
    nro_cpf VARCHAR(14),
    contato_id INT,
    endereco_id INT,
    FOREIGN KEY (contato_id) REFERENCES contato(id),
    FOREIGN KEY (endereco_id) REFERENCES endereco(id)
);

CREATE TABLE contato (
	id INT PRIMARY KEY AUTO_INCREMENT,
    txt_email VARCHAR(255) NOT NULL,
    nro_celular VARCHAR(20)
);

CREATE TABLE endereco (
	id INT PRIMARY KEY AUTO_INCREMENT,
    nro_cep VARCHAR(15) NOT NULL,
    txt_logradouro VARCHAR(255),
    txt_bairro VARCHAR(200),
    txt_cidade VARCHAR(255),
    txt_uf VARCHAR(3)
);


----------------------------------------------------------------------------------------

Para rodar o Projeto:
php -S localhost:8087 -t public


endpoint cadastrar cidadão:
http://localhost:8087/cidadoes  POST

{
    "txt_nome": "Paulo",
    "txt_sobrenome": "Roberto",
    "nro_cpf": "067.067.810-45",
    "txt_email": "paulo.roberto@gmail.com",
    "nro_celular": "75981235665",
    "nro_cep": "44500000"
}



endpoint consultar cidadoes:
http://localhost:8087/cidadoes  GET



endpoint consultar um cidadão pelo CPF:
http://localhost:8087/cidadoes/06851944520  GET



endpoint Atualizar cidadão:
http://localhost:8087/cidadoes/2  PUT

{
    "txt_nome": "Paulo",
    "txt_sobrenome": "Roberto Silva",
    "nro_cpf": "067.067.810-45",
    "txt_email": "paulo.roberto@yahoo.com",
    "nro_celular": "75981235665",
    "nro_cep": "44500000"
}



