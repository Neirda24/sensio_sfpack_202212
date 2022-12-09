<?php

namespace App\Tests\Controller;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @coversDefaultClass \App\Controller\HelloController
 * @covers ::index
 */
class HelloControllerTest extends WebTestCase
{
    public function getValidNames(): Generator
    {
        yield 'default' => [
            'uri'          => '/hello',
            'expectedName' => 'Adrien',
        ];

        yield 'name "Adrien"' => [
            'uri'          => '/hello/Adrien',
            'expectedName' => 'Adrien',
        ];

        yield 'name "Louise"' => [
            'uri'          => '/hello/Louise',
            'expectedName' => 'Louise',
        ];
    }

    /**
     * @dataProvider getValidNames
     */
    public function testNameIsDisplayed(string $uri, string $expectedName): void
    {
        $client = static::createClient();
        $client->request('GET', $uri);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString("Hello {$expectedName}", $client->getResponse()->getContent());
    }

    public function getBadRouteRequirements(): array
    {
        return [
            'numbers in {name} parameter' => [
                'method'       => 'GET',
                'uri'          => '/hello/foo1',
                'expectedCode' => 404,
            ],
            'POST method'                 => [
                'method'       => 'POST',
                'uri'          => '/hello/Adrien',
                'expectedCode' => 405,
            ],
        ];
    }

    /**
     * @dataProvider getBadRouteRequirements
     */
    public function testRouteNotWorkingWithBadRequirements(string $method, string $uri, int $expectedCode): void
    {
        $client = static::createClient();
        $client->request($method, $uri);

        $this->assertSame($expectedCode, $client->getResponse()->getStatusCode());
    }
}
