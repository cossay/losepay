<?php
namespace Losepay\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Losepay\Http\HttpClient;

class Controller
{

    /**
     *
     * @var Request;
     */
    protected $request;

    /**
     *
     * @var JsonResponse
     */
    protected $response;

    /**
     *
     * @var HttpClient
     */
    protected $httpClient;

    /**
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    public function __construct(Request $request, JsonResponse $response, HttpClient $client)
    {
        $this->request = $request;
        $this->response = $response;
        $this->httpClient = $client;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getGamers()
    {
        $response = $this->httpClient->fetchGamers()->wait();
        return $this->response->setData();
    }
}