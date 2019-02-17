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

    public function get($index)
    {
        return $this->storage['cobrancas'][$index] ?? null;
    }

    public function getItems()
    {
        return $this->storage['cobrancas'] ?? [];
    }

    public function rewind()
    {
        return reset($this->storage['cobrancas']);
    }


    public function next()
    {
        return next($this->storage['cobrancas']);
    }

    public function current()
    {
        return current($this->storage['cobrancas']);
    }

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
