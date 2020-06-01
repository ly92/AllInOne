<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/28
 * Time: 4:39 下午
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\Client\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    private $clientService;

    public function __construct()
    {
        parent::__construct();

        $this->clientService = new ClientService();

    }

    /**
     * 注册
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $this->validateRequest($request->all(), [
            'mobile' => 'required|min:11|max:11',
            'name' => 'required',
            'password' => 'required'
        ]);

        $mobile = $request->input('mobile');
        $password = $request->input('password');
        $name = $request->input('name');

        $result = $this->clientService->add($mobile, $password, $name);
        $this->setContent($result);
        return $this->response();
    }

    /**
     * 登录
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $this->validateRequest($request->all(), [
            'mobile' => 'required',
            'password' => 'required'
        ]);
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        $result = $this->clientService->login($mobile, $password);
        $this->setContent($result);
        return $this->response();
    }

    /**
     * 退出
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        $this->validateRequest($request->all(), [
            'cid' => 'required'
        ]);
        $cid = $request->input('cid');

        $result = $this->clientService->logout($cid);
        $this->setContent($result);
        return $this->response();
    }

    /**
     * 修改信息
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function modify(Request $request)
    {
        $this->validateRequest($request->all(), [
            'cid' => 'required'
        ]);
        $cid = $request->input('cid');
        $mobile = $request->input('mobile', '');
        $name = $request->input('name', '');

        $result = $this->clientService->modify($cid, $mobile, $name);
        $this->setContent($result);
        return $this->response();
    }

    /**
     * 重置密码
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function resetPwd(Request $request)
    {
        $this->validateRequest($request->all(), [
            'mobile' => 'required',
            'newPassword' => 'required'
        ]);
        $mobile = $request->input('mobile');
        $newPwd = $request->input('newPassword');
        $oldPwd = $request->input('oldPassword', '');
        $code = $request->input('code', '');

        $result = $this->clientService->resetPassword($mobile, $newPwd, $oldPwd, $code);
        $this->setContent($result);
        return $this->response();
    }


}
