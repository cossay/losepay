<?php
namespace Losepay\Http\Interceptor;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use function GuzzleHttp\Promise\settle;

class ResponseInterceptor
{

    /**
     * Resolves a single promise
     *
     * @param PromiseInterface $promise
     * @return \Losepay\Http\Interceptor\InterceptedResponse
     */
    public function single(PromiseInterface $promise)
    {
       
        $response = new InterceptedResponse();
        
        try {
            $tempResponse = $promise->wait();
            $response = new InterceptedResponse($tempResponse);
        } catch (ClientException $exception) {
            return new InterceptedResponse($exception->getResponse());
        } catch (ServerException $exception) {
            return new InterceptedResponse($exception->getResponse());
        } catch (Exception $exception) {
            $response->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setMessage($exception->getMessage());
        }
        
        return $response;
    }

    /**
     * Resolves an arra of promises
     *
     * @param PromiseInterface[] $promises
     * @return \Losepay\Http\Interceptor\InterceptedResponse[]
     */
    public function batch(array $promises)
    {
        $responses = array();
        
        foreach ($promises as $name => $promise) {
            if (! ($promise instanceof PromiseInterface)) {
                throw new Exception(sprintf('Request %s must be an instance of %s', $name, PromiseInterface::class));
            }
        }
        
        try {
            $resolvedPromises = settle($promises)->wait();
            
            foreach ($resolvedPromises as $name => $response) {
                if ($response['state'] == 'fulfilled') {
                    $responses[$name] = new InterceptedResponse($response['value']);
                } else {
                    $responses[$name] = new InterceptedResponse($response['reason']->getResponse());
                }
            }
        } catch (Exception $e) {}
        
        return $responses;
    }
}