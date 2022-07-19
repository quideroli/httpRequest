<?php
namespace quideroli\httpRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Request
{
    public function __construct($url, $query = NULL, $header = [], $body = "")
    {
        $this->url = $url;

        $this->config = [
            "headers" => $header,
            "query" => $query,
            "body" => empty($body) ? json_encode($body) : "{}"
        ];
    }

    public function get()
    {
        try {
            $send = (new Client())->get($this->url, $this->config);
            return $send->getBody()->getContents();
        }catch(ClientException $e){
            $this->error = $e;
            return false;
        }

    }

    public function post()
    {
        try {
            $send = (new Client())->post($this->url, $this->config);
            return $send->getBody()->getContents();
        }catch(ClientException $e){
            $this->error = $e;
            return false;
        }
    }

    public function put()
    {
        try {
            $send = (new Client())->put($this->url, $this->config);
            return $send->getBody()->getContents();
        }catch(ClientException $e){
            $this->error = $e;
            return false;
        }
    }

    public function delete()
    {
        try {
            $send = (new Client())->delete($this->url, $this->config);
            return $send->getBody()->getContents();
        }catch(ClientException $e){
            $this->error = $e;
            return false;
        }
    }

    public function fail($show=true)
    {
        if($show==true){
            http_response_code($this->error->getCode());
            echo $this->error->getResponse()->getBody();
            exit();
        }else{
            return $this->error->getResponse()->getBody();
        }
    }
}