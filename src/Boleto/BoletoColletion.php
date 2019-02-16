<?php

namespace PJBank\Boleto;

use Iterator;

/**
 * Lote de boletos.
 */
class BoletoColletion implements Iterator
{

    protected $storage = [];

    public function add(Boleto $boleto)
    {
        $this->storage['cobrancas'][$boleto->pedido_numero] = $boleto;
        return $this;
    }

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

    public function valid()
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
