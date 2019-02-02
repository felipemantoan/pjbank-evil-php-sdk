<?php

namespace PJBank;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

/**
 * Client Factory
 */
class PJBankClient
{
    /**
     * URI base da API.
     * @var string
     */
    const API_URI = "https://api.pjbank.com.br/";

    /**
     * URI base da API Sandbox.
     * @var string
     */
    const SANDBOX_URI = "https://sandbox.pjbank.com.br/";

    /**
     * A chave gerada após o cadastro.
     * 
     * @var string
     */
    protected $chave;

    /**
     * A credencial gerada após o cadastro.
     * 
     * @var string
     */
    protected $credencial;

    /**
     * Este método faz a instancia da classe.
     * 
     * @param array $configs
     *   Configurações contendo a chave e/ou credencial.
     * @param bool $sandbox
     *   Faz o setup para o ambiente de sandbox.
     * @param callable $handler
     *   Caso necessário faz uso de um handler diferente.
     *   E.g. \GuzzleHttp\Handler\CurlHandler.
     * 
     * @return \PJBank\PJBankClient
     */
    public static function create(array $configs = [], bool $sandbox = false, callable $handler = null) 
    {
        return new static(
            new Client([
                'base_uri' => $sandbox ? self::SANDBOX_URI : self::API_URI,
                'handler' => HandlerStack::create(
                    $handler ?? new CurlHandler()
                ),
            ]),
            $configs['credencial'] ?? null,
            $configs['chave'] ?? null
        );
    }

    /**
     * Construtor da classe.
     * 
     * @param GuzzleHttp\ClientInterface $client
     *   Uma instancia de GuzzleHttp\Client
     * @param string $credencial
     *   Credencial válida.
     * @param string $chave
     *   Uma chave válida.
     */
    public function __construct(ClientInterface $client, string $credencial = null, string $chave = null)
    {
        $this->client = $client;
        $this->credencial = $credencial;
        $this->chave = $chave;
    }

    /**
     * Este método inclui uma credencial no endpoint.
     * 
     * @param string $endpoint
     *   Parte de uma url E.g. /contadigital/{{ %credencial% }}/transacaoes
     * 
     * @return string
     *   Endpoint modificado.
     *   E.g. /contadigital/ddf9acf38aed262f90906ede9ac20333/transacaoes
     */
    protected function parseEndpoint(string $endpoint) {

        // Verifica se existe uma credencial na string.
        if (strpos($endpoint, '{{ %credencial% }}') !== false) {
            // Substitui {{ %credencial% }} por uma hash.
            // E.g. ddf9acf38aed262f90906ede9ac20333
            return strtr($endpoint, '{{ %credencial% }}', $this->credencial);
        }

        // Dispara uma excessão caso não exista uma {{ %credencial% }} no endpoint.
        throw new Exception('Num pode né!');
    }

    private function checksKeyAndCredencial(bool $withKey = true) {

        if ($withKey && (empty($this->chave) || empty($this->credencial))) {
            throw new Exception('Num pode né!');
        }
    }

    public function sendPut(string $endpoint, array $data = []) 
    {
        return $this->send('PUT', $endpoint, $data);
    }

    public function sendDelete(string $endpoint, array $data = []) 
    {
        return $this->send('DELETE', $endpoint, $data);
    }

    public function sendPost(string $endpoint, array $data = [], bool $withKey = true)
    {
        return $this->send('POST', $endpoint, $data, $withKey);
    }

    public function sendGet(string $endpoint, array $data = []) 
    {
        return $this->send('GET', $endpoint, $data);
    }

    protected function send(string $method, string $endpoint, array $data = [], bool $withKey = true) 
    {

        if ($withKey) {
            $this->checksKeyAndCredencial($withKey);
            $endpoint = $this->parseEndpoint($endpoint);
        }
        
        $response = $this->client->request($method, $endpoint, [
            RequestOptions::JSON => $data,
            RequestOptions::HEADERS => ['X-CHAVE' => $this->chave],
        ]);
        
        $data = $response
            ->getBody()
            ->getContents();

        return json_decode($data) ?: [];
    }

    public function setChave(string $chave)
    {
        $this->chave = $chave;
    }

    public function getChave() {
        return $this->chave;
    }

    public function setCredencial(string $credencial)
    {
        $this->credencial = $credencial;
    }

    public function getCredencial()
    {
        return $this->credencial;
    }

}