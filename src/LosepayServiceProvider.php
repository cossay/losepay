<?php
namespace Losepay;

use Illuminate\Support\ServiceProvider;
use Losepay\Http\HttpClient;
use GuzzleHttp\Client;

class LosepayServiceProvider extends ServiceProvider {
    
    public function register() {
        $this->app->singleton(HttpClient::class, function(){
            return  new HttpClient(new Client(), 'http://losepay.engridapps.com/v1/');
        });
    }
}