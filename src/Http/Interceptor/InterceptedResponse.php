<?php
namespace Losepay\Http\Interceptor;

use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class InterceptedResponse implements \JsonSerializable
{

    /**
     *
     * @var int
     */
    protected $code;

    /**
     *
     * @var string
     */
    protected $message;

    /**
     *
     * @var mixed
     */
    protected $payload;

    /**
     * 
     * @param GuzzleResponse $response | null
     */
    public function __construct(GuzzleResponse $response = null)
    {
        
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = null;
        $payload = null;
        
        if(null !== $response) {
            
            $contentJson = json_decode($response->getBody()->getContents());
            
            if (! empty($contentJson->code)) {
                $code = $contentJson->code;
            }
            
            if (! empty($contentJson->message)) {
                $message = $contentJson->message;
            }
            
            if (isset($contentJson->data)) {
                $payload = $contentJson->data;
            }
        }
        
        $this->setCode($code)->setMessage($message)->setPayload($payload);
    }

    /**
     * Returns response code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets response code
     *
     * @param int $code
     * @return \Losepay\Http\Interceptor\InterceptedResponse
     */
    public function setCode($code)
    {
        $this->code = (int) $code;
        
        return $this;
    }

    /**
     * Returns response message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets response message
     *
     * @param string $message
     * @return \Losepay\Http\Interceptor\InterceptedResponse
     */
    public function setMessage($message)
    {
        $this->message = (string) $message;
        
        return $this;
    }

    /**
     * Returns response payload
     *
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Sets response payload or content
     *
     * @param mixed $payload
     * @return \Losepay\Http\Interceptor\InterceptedResponse
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        
        return $this;
    }

    /**
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}