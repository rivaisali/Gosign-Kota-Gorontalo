<?php
namespace GosignClient;

use Exception;

class Request
{

     /**
      * @param  array $params Create options
     */

    public static function create($params)
    {
        return ApiRequestor::post(
            Config::getBaseUrl() . '/v1/gosign/create',
            Config::$secretKey,
            $params
        );
    }

}