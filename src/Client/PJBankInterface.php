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
     * Método envia um put usando a credencial e chave.
     */
    public function sendPut(string $endpoint, array $data = []);

    /**
     * Método envia um delete usando a credencial e chave.
     */
    public function sendDelete(string $endpoint, array $data = []);

    /**
     * Método envia um post usando a credencial e chave.
     */
    public function sendPost(string $endpoint, array $data = [], bool $withKey = true);

    /**
     * Método envia um get usando a credencial e chave.
     */
    public function sendGet(string $endpoint, array $data = []);
}
