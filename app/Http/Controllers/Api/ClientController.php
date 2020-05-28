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
		$this->clientService = new ClientService();
	}

    public function register(Request $request)
    {

        // $validatedData = $request->validate([
        //     'mobile' => 'required|min:11|max:11',
        //     'name' => 'required',
        //     'password' => 'required'
        // ]);

	    $mobile = $request->input('mobile');
	    $password = $request->input('password');
	    $name = $request->input('name');

	    $result = $this->clientService->add($mobile, $password, $name);

        return '1231';

    }

    public function login(Request $request){
		$mobile = $request->input('mobile');
		$password = $request->input('password');

		$result = $this->clientService->login($mobile, $password);

    }

    public function logout(Request $request){
    	$cid = $request->input('cid');

    	$result = $this->clientService->logout($cid);

    }

    public function modify(Request $request){
    	$cid = $request->input('cid');
    	$mobile = $request->input('mobile', '');
    	$name = $request->input('name', '');

    	$this->clientService->modify($cid, $mobile, $name);
    }

    public function resetPwd(Request $request){
    	$mobile = $request->input('mobile');
    	$newPwd = $request->input('newPassword');
	    $oldPwd = $request->input('oldPassword', '');
		$code = $request->input('code', '');

	    $result = $this->clientService->resetPassword($mobile, $newPwd, $oldPwd, $code);
    }


}
