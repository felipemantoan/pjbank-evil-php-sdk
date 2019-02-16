<?php

namespace Tests\Unit\Client;

use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;
use PJBank\Client\PJBank;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Response;
use PJBank\Exception\KeyNotFoundException;
use PJBank\Exception\CredentialNotFoundException;

class PJBankTest extends TestCase
{

    public function senderDataProvider()
    {
        return [
            [
                'chave' => 'c74d97b01eae257e44aa9d5bade97baf',
                'credencial' => 'e4da3b7fbbce2345d7772b0674a318d5',
                'method' => 'sendGet',
                'response' => new Response(
                    200,
                    [],
                    json_encode(['status' => '200', 'get' => true])
                ),
                'expected' => ['status' => 200, 'action' => 'get'],
            ],
            [
                'chave' => 'c74d97b01eae257e44aa9d5bade97baf',
                'credencial' => 'e4da3b7fbbce2345d7772b0674a318d5',
                'method' => 'sendPut',
                'response' => new Response(
                    200,
                    [],
                    json_encode(['status' => '200', 'put' => true])
                ),
                'expected' => ['status' => 200, 'action' => 'put'],
            ],
            [
                'chave' => 'c74d97b01eae257e44aa9d5bade97baf',
                'credencial' => 'e4da3b7fbbce2345d7772b0674a318d5',
                'method' => 'sendPost',
                'response' => new Response(
                    200,
                    [],
                    json_encode(['status' => '200', 'post' => true])
                ),
                'expected' => ['status' => 200, 'action' => 'post'],
            ],
            [
                'chave' => 'c74d97b01eae257e44aa9d5bade97baf',
                'credencial' => 'e4da3b7fbbce2345d7772b0674a318d5',
                'method' => 'sendDelete',
                'response' => new Response(
                    200,
                    [],
                    json_encode(['status' => '200', 'delete' => true])
                ),
                'expected' => ['status' => 200, 'action' => 'delete'],
            ],
        ];
    }

    /**
     * @dataProvider senderDataProvider
     */
    public function testSenders($key, $credential, $method, $response, $expected)
    {
        $pjbank = PJBank::create([], false, new MockHandler([$response]));

        $pjbank->setChave($key);
        $pjbank->setCredencial($credential);

        $apiResponse = $pjbank->$method('api/test/{{ %credencial% }}/');

        $this->assertArrayHasKey($expected['action'], $apiResponse);
        $this->assertEquals($expected['status'], $apiResponse['status']);

        $this->assertEquals($pjbank->getChave(), $key);
        $this->assertEquals($pjbank->getCredencial(), $credential);
    }

    /**
     */
    public function testCredentialNotFoundException()
    {
        $this->expectException(CredentialNotFoundException::class);
        $pjbank = PJBank::create(['chave' => 'test']);
        $pjbank->sendPost('api/test/{{ %credencial% }}/');
    }

    /**
     */
    public function testKeyNotFoundException()
    {
        $this->expectException(KeyNotFoundException::class);
        $pjbank = PJBank::create(['credencial' => 'test']);
        $pjbank->sendPost('api/test/{{ %credencial% }}/');
    }
}
