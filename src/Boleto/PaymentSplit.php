<?php

namespace PJBank\Boleto;

class PaymentSplit {

  /**
   * Esta propriedade guarda os dados
   * a fim de facilitar a coversão para array,
   * além de facilitar a migração para um iterator.
   *
   * @var array
   */
	protected $storage = [];

	/**
	 * Nome da pessoa física e jurídica que receberá o crédito.
	 *
	 * @var string
	 */
	protected $nome;

	/**
	 * CNPJ/CPF da pessoa física e jurídica que receberá o crédito.
	 *
	 * @var string
	 */
	protected $cnpj;

	/**
	 * Número do banco que será feito o repasse, com 3 dígitos.
	 * Para uma lista de bancos permitidos, verifique o endpoint.
	 *
	 * @var int
	 */
	protected $banco_repasse;

	/**
	 * Número da agência que será feito o repasse,
	 * com ou sem dígito dependendo do banco.
	 * Formato: 99999, 9999-9.
	 *
	 * @var string
	 */
	protected $agencia_repasse;

	/**
	 * Número da conta bancaria que será feito o repasse, com dígito.
	 * Formato: 99999-9, 9999-99.
	 *
	 * @var string
	 */
	protected $conta_repasse;

	/**
	 * Valor a ser cobrado em reais, não pode ser superior
	 * ao valor do boleto descontado as tarifas.
	 * Casas decimais devem ser separadas por ponto,
	 * máximo de 2 casas decimais, não enviar caracteres
	 * diferentes de número ou ponto.
	 * Não usar separadores de milhares.
	 *
	 * @var float
	 */
	protected $valor_fixo;

	/**
	 * Valor a ser repassado em %, não pode ser superior a 100%.
	 * Não deve ser usado em conjunto com valor_fixo.
	 * Casas decimais devem ser separadas por ponto,
	 * máximo de 2 casas decimais, não enviar caracteres
	 * diferentes de número ou ponto.
	 * Não usar separadores de milhares.
	 *
	 * @var float
	 */
	protected $valor_porcentagem;

	  /**
   * Método mágico.
   *
   * @param string $property
   *   O nome da propriedade.
   * @param mixed $value
   *   O valor da propriedade.
   */
  public function __set($property, $value) {

    $value = strip_tags($value);

    // Não deixa o a propriedade storage ser setada.
    // Verifica se a propriedade existe.
    if ($property == 'storage' || !property_exists($this, $property)) {
      return;
    }

    //Remove caracteres -(traço) e .(ponto).
    if ($property == 'cnpj') {
      $value = str_replace(['-', '.'], [''], $value);
    }

    $this->storage[strtolower($property)] = $this->$property = $value;
  }

  /**
   * Método mágico que retorna o valor de uma propriedade.
   *
   * @param string $property
   *   A propriedade a ser retornada.
   *
   * @return mixed Valor da propriedade.
   */
  public function __get($property) {
    return $this->storage[$property] ?? $this->$property ?? null;
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