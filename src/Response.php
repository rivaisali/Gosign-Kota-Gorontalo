<?php
namespace GosignClient;

use Exception;

class Response
{

    private $response;

    public function __construct($input_source = "php://input")
    {
        $headers = getallheaders();
        $client = $headers['Client'];
        $signature = $headers['Signature'];
        
        if (!isset($signature) && !isset($client)) {
            throw new Exception(
                'The SecretKey/ClientKey is null, You need to set the secret-key from Config. Please double-check Config and SecretKey key. ' .
                'for the details or contact support at gosign@gorontalokota.go.id if you have any questions.'
            );
            return false;
        }

        // Check if the payload is json or urlencoded.
        if (strpos($payload, 'payload=') === 0) {
            $payload = substr(urldecode($payload), 8);
        }

        if (!$this->validateSignature($client, $signature, $payload)) {
            throw new Exception(
                'The SecretKey/ClientKey is invalid, as it is an empty string. Please double-check your SecretKey key. ' .
                'for the details or contact support at gosign@gorontalokota.go.id if you have any questions.'
            );
            return false;
        }

        $payload = json_decode(file_get_contents($input_source), true);
        $this->response = $payload;

        return true;
    }

    public function __get($name)
    {
        if (isset($this->response->$name)) {
            return $this->response->$name;
        }
    }

    public function getResponse()
    {
        return $this->response;
    }

    protected function validateSignature($client, $goSignSignature, $payload)
    {
        $payloadHash = hash_hmac('sha256', $payload, Config::$secretKey);
        if($client == Config::$clientKey){
            return ($payloadHash == $goSignSignature);
        }else {
            return false;
        } 
    }

}