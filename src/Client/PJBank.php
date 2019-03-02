<?php

namespace PJBank\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use PJBank\Exception\CredentialNotFoundException;
use PJBank\Exception\KeyNotFoundException;
use Exception;

/**
 * Client Factory
 */
class PJBank implements PJBankInterface
{
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
     * @param array    $configs
     *   Configurações contendo a chave e/ou credencial.
     * @param bool     $sandbox
     *   Faz o setup para o ambiente de sandbox.
     * @param callable $handler
     *   Caso necessário faz uso de um handler diferente.
     *   E.g. \GuzzleHttp\Handler\CurlHandler.
     *
     * @return \PJBank\PJBankClient
     */
    public static function create(array $configs = [], bool $sandbox = true, callable $handler = null)
    {
        return new static(
            new Client(
                [
                'base_uri' => $sandbox ? self::SANDBOX_URI : self::API_URI,
                'handler' => HandlerStack::create(
                    $handler ?? new CurlHandler()
                ),
                ]
            ),
            $configs['credencial'] ?? null,
            $configs['chave'] ?? null
        );
    }

    /**
     * Construtor da classe.
     *
     * @param GuzzleHttp\ClientInterface $client
     *   Uma instancia de GuzzleHttp\Client
     * @param string                     $credencial
     *   Credencial válida.
     * @param string                     $chave
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
    protected function parseEndpoint(string $endpoint, array $tokens = [])
    {
        $tokens['{{ %credencial% }}'] = $this->credencial;

        foreach ($tokens as $token => $value) {
            // Verifica se existe o token na string.
            if (strpos($endpoint, $token) !== false) {
                // Substitui {{ %credencial% }} por uma hash.
                // E.g. ddf9acf38aed262f90906ede9ac20333
                $endpoint = str_replace($token, $value, $endpoint);
                continue;
            }

            // Dispara uma excessão caso não exista uma {{ %credencial% }} no endpoint.
            throw new Exception('Token não encontrado!');
        }

        return $endpoint;
    }

    /**
     * Esta função envia um PUT para o endpoint indicado.
     *
     * @param string $endpoint Endpoint E.g. /test/boleto/{{ %credencial% }}
     * @param array $query Fragmentos que compoe o endpoint.
     * @param array $data Dados que serão enviados.
     *
     * @return array
     * @throws PJBank\Exception\CredentialNotFoundException
     * @throws PJBank\Exception\KeyNotFoundException
     */
    public function sendPut(string $endpoint, array $query = [], array $data = [])
    {
        return $this->send('PUT', $endpoint, $query, $data);
    }

    /**
     * Esta função envia um DELETE para o endpoint indicado.
     *
     * @param string $endpoint Endpoint E.g. /test/boleto/{{ %credencial% }}
     * @param array $query Fragmentos que compoe o endpoint.
     * @param array $data Dados que serão enviados.
     *
     * @return array
     * @throws PJBank\Exception\CredentialNotFoundException
     * @throws PJBank\Exception\KeyNotFoundException
     */
    public function sendDelete(string $endpoint, array $query = [], array $data = [])
    {
        return $this->send('DELETE', $endpoint, $query, $data);
    }

    /**
     * Esta função envia um POST para o endpoint indicado.
     *
     * @param string $endpoint Endpoint E.g. /test/boleto/{{ %credencial% }}
     * @param array $query Fragmentos que compoe o endpoint.
     * @param array $data Dados que serão enviados.
     * @param bool $withKey Força a verificação de uma chave no request enviado.
     *
     * @return array
     * @throws PJBank\Exception\CredentialNotFoundException
     * @throws PJBank\Exception\KeyNotFoundException
     */
    public function sendPost(string $endpoint, array $query = [], array $data = [], bool $withKey = true)
    {
        return $this->send('POST', $endpoint, $query, $data, $withKey);
    }

    /**
     * Esta função envia um GET para o endpoint indicado.
     *
     * @param string $endpoint Endpoint E.g. /test/boleto/{{ %credencial% }}
     * @param array $query Fragmentos que compoe o endpoint.
     * @param array $data Dados que serão enviados.
     *
     * @return array
     * @throws PJBank\Exception\CredentialNotFoundException
     * @throws PJBank\Exception\KeyNotFoundException
     */
    public function sendGet(string $endpoint, array $query = [], array $data = [])
    {
        return $this->send('GET', $endpoint, $query, $data);
    }

    /**
     * Este método faz a requisisão a api.
     *
     * @param string $method
     *   Tipo da requisição a ser enviada.
     * @param string $endpoint
     *   Endpoint a que compoe a requisição.
     * @param array  $data
     *   Dados que serão enviados na requisição.
     * @param bool   $withKey
     *   Configuração que verifica se a requisição precisa da chave ou credencial.
     *
     * @return array
     *   Dados vindos da requisição.
     */
    protected function send(string $method, string $endpoint, array $query = [], array $data = [], bool $withKey = true)
    {
        if ($withKey) {
            if (empty($this->chave)) {
                throw new KeyNotFoundException();
            }

            if (empty($this->credencial)) {
                throw new CredentialNotFoundException();
            }

            $endpoint = $this->parseEndpoint($endpoint);
        }

        try {
            $response = $this->client->request(
                $method,
                $endpoint,
                [
                    RequestOptions::JSON => $data,
                    RequestOptions::HEADERS => ['X-CHAVE' => $this->chave],
                ]
            );
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }


        return json_decode($response->getBody(), true) ?: [];
    }

    /**
     * Setter da chave.
     */
    public function setChave(string $chave = null)
    {
        $this->chave = $chave;
    }

    /**
     * Getter da chave.
     */
    public function getChave()
    {
        return $this->chave;
    }

    /**
     * Setter da credencial.
     */
    public function setCredencial(string $credencial = null)
    {
        $this->credencial = $credencial;
    }

    /**
     * Getter da credencial.
     */
    public function getCredencial()
    {
        return $this->credencial;
    }
}
