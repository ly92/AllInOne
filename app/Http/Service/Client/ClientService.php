<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:23 下午
 */

namespace App\Http\Service\Client;

use App\Http\Model\Client\ClientModel;
use App\Http\Service\BaseService;

class ClientService extends BaseService
{
    private $clientModel;
    public function __construct()
    {
        parent::__construct();
        $this->clientModel = new ClientModel();
    }

    public function login($mobile, $password){
        if (empty($mobile) || empty($password)){
            throw new \Exception('请输入手机号和密码', 1001);
        }

        $client = $this->clientModel->getByMobile($mobile);
        if (empty($client)){
            throw new \Exception('当前手机号未注册', 1002);
        }
    }
}
