<?php

namespace PJBank\Client;

/**
 * Client Factory
 */
interface PJBankInterface
{

    /**
     * URI base da API.
     *
     * @var string
     */
    const API_URI = "https://api.pjbank.com.br/";

    /**
     * URI base da API Sandbox.
     *
     * @var string
     */
    const SANDBOX_URI = "https://sandbox.pjbank.com.br/";

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
    public function sendPut(string $endpoint, array $query = [], array $data = []);

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
    public function sendDelete(string $endpoint, array $query = [], array $data = []);

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
    public function sendPost(string $endpoint, array $query = [], array $data = [], bool $withKey = true);

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
    public function sendGet(string $endpoint, array $query = [], array $data = []);
}
