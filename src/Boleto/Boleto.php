<?php

namespace PJBank\Boleto;

use DateTime;

/**
 * Boleto Registrado
 * @author Matheus Fidelis
 * @email matheus.fidelis@superlogica.com
 */
class Boleto
{

    protected $storage = [];

    /**
     * Vencimento do boleto bancário.
     * @var \DateTime
     */
    protected $vencimento;

    /**
     * Valor total do boleto
     * @var float
     */
    protected $valor;

    /**
     * Valor do juros cobrado no boleto.
     * @var float
     */
    protected $juros;

    /**
     * Valor da multa cobrada em um boleto.
     *
     * @var float
     */
    protected $multa;

    /**
     * Valor de um desconto.
     *
     * @var float
     */
    protected $desconto;

    /**
     * Valor de um desconto.
     *
     * @var float
     */
    protected $desconto2;

    /**
     * Valor de um desconto.
     *
     * @var float
     */
    protected $desconto3;

    /**
     * Valor de um desconto.
     *
     * @var float
     */
    protected $diasDesconto;

    /**
     * Valor de um desconto.
     *
     * @var float
     */
    protected $diasDesconto2;

    /**
     * Valor de um desconto.
     *
     * @var float
     */
    protected $diasDesconto3;

    /**
     * Nome do cliente final.
     *
     * @var string
     */
    protected $nome_cliente;

    /**
     * CPF do cliente final.
     * @var
     */
    protected $cpf_cliente;

    /**
     * Endereço do cliente final.
     * @var
     */
    protected $endereco_cliente;

    /**
     * Numero residencial do cliente final.
     * @var
     */
    protected $numero_cliente;

    /**
     * Complemento opcional do endereço do cliente.
     *
     * @var string
     */
    protected $complemento_cliente;

    /**
     * Bairro do cliente final.
     *
     * @var
     */
    protected $bairro_cliente;

    /**
     * Cidade do cliente final.
     * @var
     */
    protected $cidade_cliente;

    /**
     * Cidade do cliente final.
     * @var
     */
    protected $cep_cliente;

    /**
     * Link do logo impresso no boleto.
     * @var
     */
    protected $logo_url;

    /**
     * Texto opcional do corpo do boleto.
     * @var
     */
    protected $texto;

    /**
     * Grupo
     * @var
     */
    protected $grupo;

    /**
     * Link do boleto
     * @var
     */
    protected $link;

    /**
     * Nosso numero de boleto.
     * @var
     */
    protected $nosso_numero;

    /**
     * Numero do pedido informado pelo cliente.
     * @var
     */
    protected $pedido_numero;

    protected $linha_digitavel;

    protected $id_unico;

    public function __set($property, $value) {

        if ($property == 'storage' || !property_exists($this, $property)) {
            return ;
        }

        $this->storage[strtolower($property)] = $this->$property = strip_tags($value);
    }

    public function __get($property) {
        return $this->storage[$property] ?? null;
    }

    /**
     * Pega os campos utilizados para a emissão do boleto bancário.
     *
     * @return array
     */
    public function toArray() : array {
        return $this->storage;
    }

}
