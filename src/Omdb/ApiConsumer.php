<?php

namespace App\Omdb;

use LogicException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class ApiConsumer implements ApiConsumerInterface
{
    public function __construct(
        private readonly HttpClientInterface $omdbApiClient,
    ) {
    }

    /**
     * {@inheritDoc}
     * @throws LogicException
     */
    public function getById(string $imdbId): array
    {
        $response = $this->omdbApiClient->request('GET', '/', [
            'query' => [
                'type' => 'movie',
                'r'    => 'json',
                'plot' => 'full',
                'i'    => $imdbId,
            ],
        ]);

        try {
            $response = $response->toArray();

            if ('False' === $response['Response']) {
                throw new LogicException('Not found');
            }

            return $response;
        } catch (Throwable) {
            throw new LogicException('Not found');
        }
    }
}
