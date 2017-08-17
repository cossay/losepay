<?php
namespace Losepay\Http;

use GuzzleHttp\Client;

class HttpClient
{

    /**
     *
     * @var string
     */
    private $base_url;

    /**
     *
     * @var Client
     */
    private $_client;

    protected $options = array();

    public function __construct(Client $client, $base_url = null)
    {
        $this->_client = $client;
        
        $this->base_url = $base_url;
    }

    /**
     *
     * @param string $url_fragment
     * @return string
     */
    protected function createUrl($url_fragment)
    {
        return sprintf('%s%s', $this->base_url, $url_fragment);
    }

    /**
     *
     * @param number $limit
     * @param number $offset
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchGamers($limit = 1000, $offset = 0)
    {
        $this->options['query'] = array(
            'limit' => $limit,
            'offset' => $offset
        );
        
        return $this->_client->getAsync($this->createUrl('gamers'), $this->options);
    }
}