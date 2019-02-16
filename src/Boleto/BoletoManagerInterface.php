<?php

namespace PJBank\Boleto;

interface BoletoManagerInterface
{
    public function sendBoleto(Boleto $boleto);

    public function sendBoletoCollection(BoletoColletion $collection);

    public function printBoletoCollection(BoletoColletion $collection, string $format = null);
}
