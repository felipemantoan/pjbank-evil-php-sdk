<?php

namespace PJBank\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

/**
 * Client Factory
 */
interface PJBankInterface
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

    public function sendPut(string $endpoint, array $data = []);

    public function sendDelete(string $endpoint, array $data = []);

    public function sendPost(string $endpoint, array $data = [], bool $withKey = true);

    public function sendGet(string $endpoint, array $data = []);

}