<?php
namespace Application\Controller;

use Laminas\Http\Client;
use Laminas\Http\Request;
use Laminas\Http\Response;

class WhiteListAPI
{
    
    static private $instance;
    private $httpClient;
    //private $url = 'http://localhost:3000/action/';
    private $url = 'https://myfirsthapi-aabajo.herokuapp.com/action/';
    
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        //nothing
    }
    
    public function init(){
         if($this->httpClient == null){
             $this->httpClient = new Client();
         }
    }
    
    public function checkMACAddress($macAddress, $ipAddress){
        $this->init();
        $request = new Request();
        $url = $this->url . '?action=checkmac&mac=' . $macAddress . '&ip=' . $ipAddress;
        $request->setUri($url);
        $resp = $this->httpClient->send($request);
        if ($resp->isSuccess()) {
            // the POST was successful
            $body = $resp->getBody();
            return $body;
        }else{
            return $resp->getReasonPhrase();
        }
    }
    
    public function setTerminalAccess($action, $macAddress, $ipAddress){
        $this->init();
        $request = new Request();
        $url = $this->url . '?action=' . $action . '&mac=' . $macAddress . '&ip=' . $ipAddress;
        $request->setUri($url); 
        $resp = $this->httpClient->send($request);
        if ($resp->isSuccess()) {
            // the POST was successful
            $body = $resp->getBody();
            return $body;
        }else{
            return $resp->getReasonPhrase();
        }
    }
    
    public function getAllowedTerminals(){
        $this->init();
        $request = new Request();
        $url = $this->url . '?action=getterminals';
        $request->setUri($url); 
        $resp = $this->httpClient->send($request);
        if ($resp->isSuccess()) {
            // the POST was successful
            $body = $resp->getBody();
            return $body;
        }else{
            return $resp->getReasonPhrase();
        }
    }
}
