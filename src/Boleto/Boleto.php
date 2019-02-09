<?php

namespace PJBank\Boleto;

use DateTime;

/**
 * Boleto Registrado
 * @author Matheus Fidelis
 * @email matheus.fidelis@superlogica.com
 */
class Boleto {

  /**
   * Este parâmetro guarda os dados
   * a fim de facilitar a coversão para array,
   * além de facilitar a migração para um iterator.
   * @var array
   */
  protected $storage = [];

  /**
   * Vencimento da cobrança no formato MM/DD/AAAA.
   * @var \DateTime
   */
  protected $vencimento;

  /**
   * Valor a ser cobrado em reais.
   * Casas decimais devem ser separadas por ponto,
   * máximo de 2 casas decimais, não enviar caracteres
   * diferentes de número ou ponto.
   * Não usar separadores de milhares.
   *
   * @var float
   */
  protected $valor;

  /**
   * Taxa de juros ao mês.
   * Valor informado será dividido por 30 pra ser encontrado a taxa diária.
   * Casas decimais devem ser separadas por ponto,
   * máximo de 2 casas decimais, não enviar
   * caracteres diferentes de número ou ponto.
   * Não usar separadores de milhares.
   *
   * @var float
   */
  protected $juros;

  /**
   * Taxa de multa por atraso.
   * Casas decimais devem ser separadas por ponto,
   * máximo de 2 casas decimais,
   * não enviar caracteres diferentes de número ou ponto.
   * Não usar separadores de milhares.
   *
   * @var float
   */
  protected $multa;

  /**
   * Valor do desconto por pontualidade, em Reais.
   * Casas decimais devem ser separadas por ponto,
   * máximo de 2 casas decimais, não enviar caracteres
   * diferentes de número ou ponto.
   * Não usar separadores de milhares.
   *
   * @var float
   */
  protected $desconto;

  /**
   * Valor do desconto por pontualidade, em Reais.
   * Casas decimais devem ser separadas por ponto,
   * máximo de 2 casas decimais, não enviar caracteres
   * diferentes de número ou ponto.
   * Não usar separadores de milhares.
   *
   * @var float
   */
  protected $desconto2;

  /**
   * Valor do desconto por pontualidade, em Reais.
   * Casas decimais devem ser separadas por ponto,
   * máximo de 2 casas decimais, não enviar caracteres
   * diferentes de número ou ponto.
   * Não usar separadores de milhares.
   *
   * @var float
   */
  protected $desconto3;

  /**
   * Dias de desconto antes da data de vencimento.
   *
   * @var int
   */
  protected $diasDesconto;

  /**
   * Dias de desconto antes da data de vencimento.
   *
   * @var int
   */
  protected $diasDesconto2;

  /**
   * Dias de desconto antes da data de vencimento.
   *
   * @var int
   */
  protected $diasDesconto3;

  /**
   * Nome do cliente final.
   *
   * @var string
   */
  protected $nome_cliente;

  /**
   * CPF ou CNPJ do pagador.
   * Por enquanto não é obrigatório,
   * porém por determinação da Febraban
   * será obrigatório em breve.
   *
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
   * Identificação do grupo.
   * É uma string que identifica um grupo de boletos.
   * Quando um valor é passado neste campo, é retornado
   * um link adicional para impressão de todos os boletos
   * do mesmo grupo de uma vez.
   * Recomendado para imprimir carnês.
   * @var
   */
  protected $grupo;

  /**
   * Link do boleto
   * @var string
   */
  protected $link;

  /**
   * Nosso numero de boleto.
   * @var int
   */
  protected $nosso_numero;

  /**
   * Numero do pedido informado pelo cliente.
   * @var string
   */
  protected $pedido_numero;

  /**
   * Opcionalmente informa a espécie do titulo da cobrança.
   * @var string
   */
  protected $especie_documento;

  protected $linha_digitavel;

  protected $id_unico;

  /**
   * Opcionalmente informe uma URL de Webhook.
   * Iremos chamá-la com as novas informações sempre que a cobrança for atualizada.
   * @var string
   */
  protected $webhook;

  /**
   * Construtor básico.
   *
   * @param array $data
   *   Dados que compoe o boleto.
   */
  public function __construct(array $data = [])
  {

    foreach ($data as $property => $value) {
      $this->__set($property, $value);
    }
  }

  /**
   * Método mágico.
   *
   * @param string $property
   *   O nome da propriedade.
   * @param mixed $value
   *   O valor da propriedade.
   */
  public function __set($property, $value)
  {

    $value = strip_tags($value);

      // Não deixa o a propriedade storage ser setada.
      // Verifica se a propriedade existe.
    if ($property == 'storage' || !property_exists($this, $property)) {
      return;
    }

      //Remove caracteres -(traço) e .(ponto).
    if ($property == 'cpf_cliente' || $property == 'cep_cliente') {
      $value = str_replace(['-', '.'], [''], $value);
    }

      // Converte o dado previamente.
    if ($property == 'vencimento') {
      $date = new DateTime($value);
      $value = $date->format('m/d/Y');
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
  public function __get($property)
  {
    return $this->storage[$property] ?? $this->$property ?? null;
  }

  /**
   * Pega os campos utilizados para a emissão do boleto bancário.
   *
   * @return array
   */
  public function toArray() : array
  {
    return $this->storage;
  }

}
