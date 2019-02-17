<?php

namespace PJBank\Boleto;

use PJBank\Client\PJBankInterface;

class BoletoManager implements BoletoManagerInterface
{
    /**
     * Instância de PJBank\Client\PJBank.
     *
     * @var \PJBank\Client\PJBank
     */
    protected $pjBank;

    public function __construct(PJBankInterface $pjBank)
    {
        $this->pjBank = $pjBank;
    }

    public function getPjBank()
    {
        return $this->pjBank;
    }

    public function sendBoleto(Boleto $boleto)
    {
        return $this->pjBank->sendPost('/recebimentos/{{ %credencial% }}/transacoes', $boleto->toArray());
    }

    public function sendBoletoCollection(BoletoColletion $collection)
    {
        return $this->pjBank->sendPost('/recebimentos/{{ %credencial% }}/transacoes', $collection->toArray());
    }

    public function printBoletoCollection(BoletoColletion $collection, string $format = null)
    {

        $data = [
            'formato' => $format,
        ];

        foreach ($collection as $boleto) {
            $data['pedido_numero'][] = $boleto->pedido_numero;
        }

        return $this->pjBank->sendPost('/recebimentos/{{ %credencial% }}/transacoes/lotes', $data);
    }
}
