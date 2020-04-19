<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class Guzzle extends Controller
{
    public $client;
    public $headers;
    public $baseUrl;


    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Authorization' => config('apiUrl.basicAuth'),
            'Accept' => 'application/json',
        ];
        $this->baseUrl = config('apiUrl.baseUrl');
    }


    /**
     * Undocumented function
     *
     * @param string $url
     * @param array $data
     * @return void
     */
    public function post(string $url, array $data)
    {
        try {
            $postArray = [
                'headers' => $this->headers,
                'form_params' => $data
            ];
            $this->client->post($this->baseUrl . $url, $postArray);
            return true;
        } catch (Exception $exception) {
                return $this->handleException($exception);
        }
    }


    /**
     * To handle exceptions during http request
     *
     * @param [type] $exception
     * @return void
     */
    private function handleException($exception)
    {
        $responseBody = $exception->getResponse()->getBody()->getContents();

        if (!empty($responseBody)) {
            $responseBody = json_decode($responseBody);

            $validationErrorResponse = [
                "CODE"    =>  config('httpCodes.required'),
                "MESSAGE" => $responseBody->message,
                "LINE"    => $exception->getLine(),
                "FILE"    => $exception->getFile(),
            ];

            (new Response($validationErrorResponse, config('httpCodes.success')))->header('Content-Type', 'application/json')->send();
            exit;
        }
    }
}
