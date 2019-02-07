<?php

require_once 'vendor/autoload.php';

use PJBank\Client\PJBank;

$configs = [
    'credencial' => '300552ecb799dade0f8d796f49400e8c25cf20ba',
    'chave' => '50b1c7119e5ca4d97095b64f8ea436c08551050d',

];

$client = PJBank::create($configs, true);

// $body = $client->sendPost('/recebimentos', [
//     'nome_empresa' => 'Felipe DEV',
//     'conta_repasse' => '79922-2',
//     'agencia_repasse' => '6548',
//     'banco_repasse' => '033',
//     'cnpj' => '32103560000168',
//     'ddd' => 19,
//     'telefone' => '996699954',
//     'email' => 'email@example.com',
// ], false);

$data = [
    'vencimento' => '12/30/2019',
    'valor' => 50.75,
    'juros' => 0,
    'multa' => 0,
    'desconto' => '',
    'nome_cliente' => 'Cliente de Exemplo',
    'cpf_cliente' => '62936576000112',
    'endereco_cliente' => 'Rua Joaquim Vilac',
    'numero_cliente' => '509',
    'complemento_cliente' => '',
    'bairro_cliente' => 'Vila Teixeira',
    'cidade_cliente' => 'Campinas',
    'estado_cliente' => 'SP',
    'cep_cliente' => '13301510',
    'logo_url' => 'http://wallpapercave.com/wp/xK64fR4.jpg',
    'texto' => 'Exemplo de emissão de boleto',
    'grupo' => 'Boletos',
    'pedido_numero' => '2342',
];


$body = $client->sendPost('/recebimentos/{{ %credencial% }}/transacoes', $data);

print_r($body);


// $configs = [
//     'chave' => '7a8c71c31d15989071b447421cd9a8ada3c9848b',
//     'credencial' => 'ba86369f6cf0815682fcba3eda57fb80a52cf23a',
// ];

// $client = PJBankClient::create($configs, true);

// print_R($client);