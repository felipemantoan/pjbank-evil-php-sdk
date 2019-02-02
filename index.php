<?php

require_once 'vendor/autoload.php';

use PJBank\PJBankClient;

$client = PJBankClient::create([], true);

$body = $client->sendPost('/recebimentos', [
    'nome_empresa' => 'Felipe DEV',
    'conta_repasse' => '79922-2',
    'agencia_repasse' => '6548',
    'banco_repasse' => '033',
    'cnpj' => '32103560000168',
    'ddd' => 19,
    'telefone' => '996699954',
    'email' => 'email@example.com',
], false);

print_r($body);