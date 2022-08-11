<?php

namespace GosignClient;

/**
 * GoSign Configuration
 */
class Config
{

    /**
     * Your app's secret key
     * 
     * @static
     */
    public static $secretKey;
    /**
     * Your apps client key
     * 
     * @static
     */
    public static $clientKey;
   
    /**
     * Default options for every request
     * 
     * @static
     */
    public static $curlOptions = array();

    const BASE_URL = 'https://api.gorontalokota.go.id';

    /**
     * Get baseUrl
     * 
     * @return string Midtrans API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        Config::BASE_URL;
    }

}
