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
   

    const BASE_URL = 'http://localhost:8000/';

    /**
     * Get baseUrl
     * 
     * @return string Gosign API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        return Config::BASE_URL;
    }

}
