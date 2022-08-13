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
            Config::getBaseUrl() . 'api/v1/gosign/create',
            Config::$secretKey,
            $params
        );
    }

}