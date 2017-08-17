<?php
namespace Losepay;

use Illuminate\Support\ServiceProvider;
use Losepay\Http\HttpClient;
use GuzzleHttp\Client;
use Losepay\Http\Interceptor\ResponseInterceptor;

class LosepayServiceProvider extends ServiceProvider {
    
    public function register() {
        $this->app->singleton(HttpClient::class, function(){
            $options = array(
                'base_uri' => 'http://losepay.engridapps.com/v1/'
            );
            
            return  new HttpClient(new Client(), new ResponseInterceptor());
        });
    }
    
    public function boot() {
        require_once __DIR__.'/routes/routes.php';
    }
}