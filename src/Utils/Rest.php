<?php

namespace AdminSDK\Utils;

use AdminSDK\Exceptions\ServiceException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Rest
{
    public static function sendRequest(string $url, string $method, array $options = []): array
    {
        $client = new Client;

        try {
            $response = $client->request($method, $url, $options);

            return json_decode($response->getBody()->getContents(), true)['data'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $message = json_decode($e->getResponse()->getBody())->message;
            } else {
                $message = null;
            }

            throw new ServiceException($message);
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    public static function get(string $url, string $secretApiKey, array $params = []): array
    {
        $options = [
            'query' => $params,
            'headers' => [
                'X-Magic-Secret-key' => $secretApiKey,
            ],
        ];

        return static::sendRequest($url, 'GET', $options);
    }

    public static function post(string $url, string $secretApiKey, array $body = []): array
    {
        $options = [
            'body' => json_encode($body),
            'headers' => [
                'X-Magic-Secret-key' => $secretApiKey,
            ],
        ];

        return static::sendRequest($url, 'POST', $options);
    }
}
