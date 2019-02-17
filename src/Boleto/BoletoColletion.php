<?php

namespace PJBank\Boleto;

use Iterator;

/**
 * Lote de boletos.
 */
class BoletoColletion implements Iterator
{

    protected $storage = [];

    /**
     * Esta função inclui um novo boleto ao lote.
     *
     * @param \PJBank\Boleto\Boleto $boleto Um Boleto Preenchido.
     *
     * @return $this
     */
    public function add(Boleto $boleto)
    {
        $this->storage['cobrancas'][$boleto->pedido_numero] = $boleto;
        return $this;
    }

    /**
     * Esta função inclui uma coleção de boletos ao lote.
     *
     * @param array[\PJBank\Boleto\Boleto] $boletos Lista de boletos.
     *
     * @return $this
     */
    public function addItems(array $boletos = [])
    {
        foreach ($boletos as $boleto) {
            $this->add($boleto);
        }
        return $this;
    }

    /**
     * Retona o elemento do lote
     *
     * @param string $index Index do boleto no lote.
     *
     * @return \PJBank\Boleto\Boleto|null
     */
    public function get($index)
    {
        return $this->storage['cobrancas'][$index] ?? null;
    }

    /**
     * Retorna o lote de boletos.
     *
     * @return array[\PJBank\Boleto\Boleto]|array[null]
     */
    public function getItems()
    {
        return $this->storage['cobrancas'] ?? [];
    }

    /**
     * Caminha para o item anterior do array.
     */
    public function rewind()
    {
        return reset($this->storage['cobrancas']);
    }

    /**
     * Caminha para o próximo item do array.
     */
    public function next()
    {
        return next($this->storage['cobrancas']);
    }

    /**
     * Retorna o item atual do array.
     */
    public function current()
    {
        return current($this->storage['cobrancas']);
    }

    /**
     * Retorna o index atual do array.
     */
    public function key()
    {
        return key($this->storage['cobrancas']);
    }

    /**
     * Verifica se o array está válido.
     *
     * @return bool
     */
    public function valid() : bool
    {
        return !empty(key($this->storage['cobrancas']));
    }

    /**
     * Pega os campos utilizados para a emissão do boleto bancário.
     *
     * @return array
     */
    public function toArray() : array
    {
        $collection = [];
        foreach ($this->storage['cobrancas'] as $boleto) {
            $collection['cobrancas'][] = $boleto->toArray();
        }
        return $collection;
    }
}
