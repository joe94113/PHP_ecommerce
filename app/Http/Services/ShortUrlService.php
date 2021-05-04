<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class ShortUrlService
{
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    public function makeShortUrl($url)
    {
        $accesstoken = '20f07f91f3303b2f66ab6f61698d977d69b83d64';
        $data = [
            'url' => $url
        ];
        $response = $this->client->request(
            'POST',
            "https://api.pics.ee/v1/links/?access_token=$accesstoken",
            [
                'header' => ['Content-type' => 'application/json'],
                'body' => json_encode($data)
            ]
        );

        $contents = $response->getBody()->getContents();  // 取得較乾淨內容
        $contents = json_decode($contents);
        return $contents->data->picseeUrl;
    }
}
