<?php
namespace GosignClient;

use Exception;

class SignRequest
{

     /**
      * @param  array $params Create options
     */

    public static function create($params)
    {
        return ApiRequestor::post(
            Config::getBaseUrl() . 'api/v1/create',
            Config::$clientKey,
            Config::$secretKey,
            $params
        );
    }

     /**
     * Retrieve Signed status
     *
     * @param string $id Document ID or Document ID
     *
     * @return mixed[]
     * @throws Exception
     */
    public static function status($id)
    {
        return ApiRequestor::get(
            Config::getBaseUrl() . 'api/v1/' . $id . '/status/sign',
            Config::$clientKey,
            Config::$secretKey,
            false
        );
    }

}