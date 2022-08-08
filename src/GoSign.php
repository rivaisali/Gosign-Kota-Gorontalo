<?php
namespace GoSign;

class GoSign
{
    private $secret;
    private $data;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function getData()
    {
        return $this->data;
    }

  
    public function getSecret()
    {
        return $this->secret;
    }


    public function handle()
    {
        if (!$this->validate()) {
            return false;
        }
    }

    public function validate()
    {
        $headers = getallheaders();
        $signature = $headers['Signature'];

        if (!isset($signature)) {
            return false;
        }

        $payload = file_get_contents('php://input');

        // Check if the payload is json or urlencoded.
        if (strpos($payload, 'payload=') === 0) {
            $payload = substr(urldecode($payload), 8);
        }

        if (!$this->validateSignature($signature, $payload)) {
            return false;
        }

        $this->data = json_decode($payload,true);
        $this->event = $event;
        $this->delivery = $delivery;
        return true;
    }

    protected function validateSignature($goSignSignatureHeader, $payload)
    {
        $payloadHash = hash_hmac('sha256', $payload, $this->secret);
        return ($payloadHash === $gitHubSignature);
    }
}