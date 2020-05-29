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

        try {
            $result = $this->clientService->add($mobile, $password, $name);
            $this->setContent($result);
        } catch (\Exception $e) {
            $this->setCodeAndMessage($e->getCode(), $e->getMessage());
        }
        return $this->response();
    }

    public function login(Request $request){
		$mobile = $request->input('mobile');
		$password = $request->input('password');

        try {
            $result = $this->clientService->login($mobile, $password);
            $this->setContent($result);
        } catch (\Exception $e) {
            $this->setCodeAndMessage($e->getCode(), $e->getMessage());
        }
        return $this->response();
    }

    public function logout(Request $request){
    	$cid = $request->input('cid');

        try {
            $result = $this->clientService->logout($cid);
            $this->setContent($result);
        } catch (\Exception $e) {
            $this->setCodeAndMessage($e->getCode(), $e->getMessage());
        }
        return $this->response();
    }

    public function modify(Request $request){
    	$cid = $request->input('cid');
    	$mobile = $request->input('mobile', '');
    	$name = $request->input('name', '');

        try {
            $this->clientService->modify($cid, $mobile, $name);
        } catch (\Exception $e) {
        }
    }

    public function resetPwd(Request $request){
    	$mobile = $request->input('mobile');
    	$newPwd = $request->input('newPassword');
	    $oldPwd = $request->input('oldPassword', '');
		$code = $request->input('code', '');

        try {
            $result = $this->clientService->resetPassword($mobile, $newPwd, $oldPwd, $code);
        } catch (\Exception $e) {
        }
    }


}
