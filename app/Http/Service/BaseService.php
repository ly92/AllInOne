<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:22 下午
 */

namespace App\Http\Service;

class BaseService
{
	public function __construct()
	{
	}

    /**
     * @param $message
     * @param $code
     * @throws \Exception
     */
	public function throwError($message = '', $code = 1000){
	    throw new \Exception($message, $code);
    }


}
