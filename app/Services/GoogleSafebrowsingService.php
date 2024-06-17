<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class GoogleSafebrowsingService
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $clientId,
        private readonly string $clientVersion,
        private readonly string $url
    )
    {}

    public function isUrlSafe(string $url): bool
    {
        $client = new Client();
        $apiUrl = $this->url . "/threatMatches:find?key=$this->apiKey";

        $response = $client->post($apiUrl, [
            'json' => [
                'client' => [
                    'clientId' => $this->clientId,
                    'clientVersion' => $this->clientVersion
                ],
                'threatInfo' => [
                    'threatTypes' => ["MALWARE", "SOCIAL_ENGINEERING"],
                    'platformTypes' => ["ANY_PLATFORM"],
                    'threatEntryTypes' => ["URL"],
                    'threatEntries' => [
                        ['url' => $url]
                    ]
                ]
            ]
        ]);

        $responseBody = $response->getBody()->getContents();
        $result = json_decode($responseBody, true);

        return empty($result['matches']);
    }
}
