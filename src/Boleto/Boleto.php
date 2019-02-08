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

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public function getNossoNumero()
    {
        return $this->nosso_numero;
    }

    /**
     * Undocumented function
     * @return void
     */
    public function getIdUnico()
    {
        return $this->id_unico;
    }

    /**
     * Setter do numero do pedido
     * @param $pedido_numero
     */
    public function setPedidoNumero($pedido_numero)
    {
        $this->pedido_numero = $pedido_numero;
        return $this;
    }

    /**
     * Numero do pedido
     * @return mixed
     */
    public function getPedidoNumero() {
        return $this->pedido_numero;
    }

    /**
     * Undocumented function
     * @return void
     */
    public function getLinhaDigitavel()
    {
        return $this->linha_digitavel;
    }

    /**
     * @return date
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * @param date $vencimento
     * @return Boleto
     */
    public function setVencimento($vencimento)
    {
        $this->vencimento = new DateTime($vencimento);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     * @return Boleto
     */
    public function setValor(float $valor = 0.0)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return float
     */
    public function getJuros()
    {
        return $this->juros;
    }

    /**
     * @param float $juros
     * @return Boleto
     */
    public function setJuros(float $juros = 0.0)
    {
        $this->juros = $juros;
        return $this;
    }

    /**
     * @return float
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * @param float $multa
     * @return Boleto
     */
    public function setMulta(float $multa = 0.0)
    {
        $this->multa = $multa;
        return $this;
    }

    /**
     * @return float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * @param float $desconto
     * @return Boleto
     */
    public function setDesconto(float $desconto = 0.0)
    {
        $this->desconto = $desconto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomeCliente()
    {
        return $this->nome_cliente;
    }

    /**
     * @param mixed $nome_cliente
     * @return Boleto
     */
    public function setNomeCliente(string $nome_cliente = null)
    {
        $this->nome_cliente = $nome_cliente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCpfCliente()
    {
        return $this->cpf_cliente;
    }

    /**
     * @param mixed $cpf_cliente
     * @return Boleto
     */
    public function setCpfCliente(string $cpf_cliente = null)
    {
        $this->cpf_cliente = str_replace(['-', '.'], [], $cpf_cliente);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnderecoCliente()
    {
        return $this->endereco_cliente;
    }

    /**
     * @param mixed $endereco_cliente
     * @return Boleto
     */
    public function setEnderecoCliente($endereco_cliente)
    {
        $this->endereco_cliente = $endereco_cliente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumeroCliente()
    {
        return $this->numero_cliente;
    }

    /**
     * @param mixed $numero_cliente
     * @return Boleto
     */
    public function setNumeroCliente(int $numero_cliente = 0)
    {
        $this->numero_cliente = $numero_cliente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComplementoCliente()
    {
        return $this->complemento_cliente;
    }

    /**
     * @param mixed $complemento_cliente
     * @return Boleto
     */
    public function setComplementoCliente(string $complemento_cliente = null)
    {
        $this->complemento_cliente = strip_tags($complemento_cliente);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBairroCliente()
    {
        return $this->bairro_cliente;
    }

    /**
     * @param mixed $bairro_cliente
     * @return Boleto
     */
    public function setBairroCliente($bairro_cliente)
    {
        $this->bairro_cliente = $bairro_cliente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCidadeCliente()
    {
        return $this->cidade_cliente;
    }

    /**
     * @param mixed $cidade_cliente
     * @return Boleto
     */
    public function setCidadeCliente(string $cidade_cliente = null)
    {
        $this->cidade_cliente = $cidade_cliente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCepCliente()
    {
        return $this->cep_cliente;
    }

    /**
     * @param mixed $cep_cliente
     * @return Boleto
     */
    public function setCepCliente($cep_cliente)
    {
        $this->cep_cliente = str_replace(['-', '.'], [], $cep_cliente);;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogoUrl()
    {
        return $this->logo_url;
    }

    /**
     * @param mixed $logo_url
     * @return Boleto
     */
    public function setLogoUrl($logo_url)
    {
        $this->logo_url = $logo_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     * @return Boleto
     */
    public function setTexto(string $texto = null)
    {
        $this->texto = strip_tags($texto);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param mixed $grupo
     * @return Boleto
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
        return $this;
    }


    /**
     * Pega os campos utilizados para a emissão do boleto bancário.
     * @return array
     */
    public function getValues()
    {
        $boletoValues = [];
        foreach (get_object_vars($this) as $key => $value) {
            $boletoValues[$key] = $value ?: null;
        }
        return $boletoValues;
    }

}
