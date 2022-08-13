<?php

namespace GosignClient;

use Exception;
/**
 * Send request to Gosign API
 */

class ApiRequestor
{

    /**
     * Send GET request
     *
     * @param string $url
     * @param string $secret_key
     * @param mixed[] $data_hash
     * @return mixed
     * @throws Exception
     */
    public static function get($url, $client_key, $secret_key, $data_hash)
    {
        return self::remoteCall($url, $client_key, $secret_key, $data_hash, 'GET');
    }

    /**
     * Send POST request
     *
     * @param string $url
     * @param string $secret_key
     * @param mixed[] $data_hash
     * @return mixed
     * @throws Exception
     */
    public static function post($url, $client_key, $secret_key, $data_hash)
    {
        return self::remoteCall($url, $client_key, $secret_key, $data_hash, 'POST');
    }

    /**
     * Send PATCH request
     *
     * @param string $url
     * @param string $secret_key
     * @param mixed[] $data_hash
     * @return mixed
     * @throws Exception
     */
    public static function patch($url, $client_key, $secret_key, $data_hash)
    {
        return self::remoteCall($url, $client_key, $secret_key, $data_hash, 'PATCH');
    }

    /**
     * Actually send request to API server
     *
     * @param string $url
     * @param string $secret_key
     * @param mixed[] $data_hash
     * @param bool $post
     * @return mixed
     * @throws Exception
     */
    public static function remoteCall($url, $client_key, $secret_key, $data_hash, $method)
    {
        $ch = curl_init();

        if (!$client_key && !$secret_key) {
            throw new Exception(
                'The SecretKey/ClientKey is null, You need to set the server-key from Config. Please double-check Config and SecretKey key. ' .
                'for the details or contact support at gosign@gorontalokota.go.id if you have any questions.'
            );
        } else {
            if (!$client_key && $secret_key == "") {
                throw new Exception(
                    'The SecretKey/ClientKey is invalid, as it is an empty string. Please double-check your SecretKey key. ' .
                    'for the details or contact support at gosign@gorontalokota.go.id if you have any questions.'
                );
            } elseif (preg_match('/\s/',$client_key) && preg_match('/\s/',$secret_key)) {
                throw new Exception(
                    'The SecretKey/ClientKey is contains white-space. Please double-check your API key. Please double-check your SecretKey key. ' .
                    'for the details or contact support at gosign@gorontalokota.go.id if you have any questions.'
                );
            }
        }


        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'User-Agent: gosign-client-php-v1.0.0',
                'Authorization: Basic ' . base64_encode($client_key . ':'.$secret_key)
            ),
            CURLOPT_RETURNTRANSFER => 1
        );


        if ($method != 'GET') {

            if ($data_hash) {
                $body = json_encode($data_hash);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }

            if ($method == 'POST') {
                $curl_options[CURLOPT_POST] = 1;
            } elseif ($method == 'PATCH') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            }
        }

        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        // curl_close($ch);



        if ($result === false) {
            throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        } else {
            try {
                $result_array = json_decode($result);
            } catch (Exception $e) {
                throw new Exception("API Request Error unable to json_decode API response: ".$result . ' | Request url: '.$url);
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (isset($result_array->status_code) && $result_array->status_code >= 401 && $result_array->status_code != 407) {
                throw new Exception('Gosign API is returning API error. HTTP status code: ' . $result_array->status_code . ' API response: ' . $result, $result_array->status_code);
            } elseif ($httpCode >= 400) {
                throw new Exception('Gosign API is returning API error. HTTP status code: ' . $httpCode . ' API response: ' . $result, $httpCode);
            } else {
                return $result_array;
            }
        }
    }

}
