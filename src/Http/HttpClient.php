<?php
namespace Losepay\Http;

use GuzzleHttp\Client;
use Losepay\Http\Interceptor\ResponseInterceptor;

class HttpClient
{

    /**
     *
     * @var Client
     */
    private $_client;

    /**
     *
     * @var ResponseInterceptor
     */
    private $responseInterceptor;

    /**
     *
     * @var array
     */
    protected $options = array();

    public function __construct(Client $client, ResponseInterceptor $responseInterceptor)
    {
        $this->_client = $client;
        
        $this->responseInterceptor = $responseInterceptor;
    }

    /**
     * Return http response interceptor
     *
     * @return \Losepay\Http\Interceptor\ResponseInterceptor
     */
    public function getResponseInterceptor()
    {
        return $this->responseInterceptor;
    }

    /**
     * Sets http response interceptor
     *
     * @param ResponseInterceptor $interceptor
     */
    public function setResponseInterceptor(ResponseInterceptor $interceptor)
    {
        $this->responseInterceptor = $interceptor;
    }

    /**
     * Fetches a number of gamers
     *
     * @param int $limit
     * @param int $offset
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchGamers($limit = 1000, $offset = 0)
    {
        $this->options['query'] = array(
            'limit' => $limit,
            'offset' => $offset
        );
        
        return $this->_client->getAsync('gamers', $this->options);
    }

    /**
     * Fetces a single gamer by its unique Id
     *
     * @param int $id
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchGamerById($id)
    {
        return $this->_client->getAsync(sprintf('gamers/%d', $id));
    }
}