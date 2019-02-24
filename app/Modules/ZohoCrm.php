<?php

namespace App\Modules;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class ZohoCrm
{
    private $guzzle_client;

    /**
     * ZohoCrm constructor.
     */
    public function __construct()
    {
        $this->guzzle_client = new Client();
    }

    /**
     * Send various requests to Zoho CRM
     *
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param string $body
     * @return array|mixed
     */
    public function sendRequest(string $method, string $uri, Array $headers,  $body = '')
    {

        if ($method == 'get') {
            $data = compact('headers');
        } else {
            $body = json_encode($body);
            $data = compact('headers', 'body');
        }


        try {
            global $response;
            $response = $this->guzzle_client->request($method, $uri, $data);
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }

        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody, true);

        return $data;
    }
}