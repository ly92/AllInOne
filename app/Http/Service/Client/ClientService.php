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

	/**
	 * 用户信息
	 * @param $cid
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
    public function getById($cid){
    	return $this->clientModel->getById($cid);
    }

	/**
	 * 用户信息
	 * @param $mobile
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
    public function getByMobile($mobile){
    	return $this->clientModel->getByMobile($mobile);
    }

	/**
	 * 登录
	 * @param $mobile
	 * @param $password
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 * @throws \Exception
	 */
    public function login($mobile, $password){
        if (empty($mobile) || empty($password)){
            throw new \Exception('请输入手机号和密码', 1001);
        }

        $client = $this->clientModel->getByMobile($mobile);
        if (empty($client)){
            throw new \Exception('当前手机号未注册', 1002);
        }

        if ($client['password'] != $password){
        	throw new \Exception('密码错误', 1003);
        }

        //重复登录验证,生成本次登录的token
	    $token = md5($client['id'] . time());
        //记录token
	    $this->clientModel->update($client['id'], ['token' => $token, 'modifyTime' => time()]);

	    $client['token'] = $token;

	    //不要暴露密码
	    unset($client['password']);

        return $client;
    }

	/**
	 * 退出登录
	 * @param $cid
	 * @return int
	 * @throws \Exception
	 */
    public function logout($cid){
    	if (empty($cid)){
    		throw new \Exception('操作错误', 1004);
	    }

	    $client = $this->clientModel->getById($cid);
	    if (empty($client)){
		    throw new \Exception('账户不存在', 1007);
	    }
    	//将记录的token清空
	    $this->clientModel->update($client['id'], ['token' => '', 'modifyTime' => time()]);

		return 1;
    }

	/**
	 * 注册
	 * @param $mobile
	 * @param $password
	 * @param $name
	 * @return int
	 * @throws \Exception
	 */
    public function add($mobile, $password, $name){
	    if (empty($mobile) || empty($password)){
		    throw new \Exception('请输入手机号和密码', 1005);
	    }

	    $client = $this->clientModel->getByMobile($mobile);
	    if (!empty($client)){
		    throw new \Exception('当前手机号已注册', 1006);
	    }

	    $id = $this->clientModel->add([
	    	'name' => $name,
		    'mobile' => $mobile,
		    'password' => $password,
		    'creationTime' => time()
	    ]);

	    return $id;
    }

	/**
	 * 修改密码
	 * @param $mobile
	 * @param $newPassword
	 * @param string $oldPassword
	 * @param string $code
	 * @return string
	 * @throws \Exception
	 */
    public function resetPassword($mobile, $newPassword, $oldPassword = '', $code = ''){
	    if (empty($mobile) || empty($newPassword)){
		    throw new \Exception('请输入手机号和新的密码', 1005);
	    }

	    $client = $this->clientModel->getByMobile($mobile);
	    if (empty($client)){
		    throw new \Exception('当前手机号未注册', 1006);
	    }

	    if (!empty($oldPassword) && $client['password'] == $oldPassword){
	    	$this->clientModel->update($client['id'], [
	    		'password' => $newPassword,
			    'modifyTime' => time()
		    ]);
	    }
		return 'success';
    }

	/**
	 * 修改信息
	 * @param $cid
	 * @param $mobile
	 * @return string
	 * @throws \Exception
	 */
    public function modify($cid, $mobile, $name){
	    if (empty($cid)){
		    throw new \Exception('操作错误', 1004);
	    }

	    $client = $this->clientModel->getById($cid);
	    if (empty($client)){
		    throw new \Exception('账户不存在', 1007);
	    }

	    $data = [];
	    if (!empty($mobile)){
	    	$data['mobile'] = $mobile;
	    }
	    if (!empty($name)){
	    	$data['name'] = $name;
	    }
	    if (empty($data)){
	    	return 'success';
	    }

	    $data['modifyTime'] = time();
	    if ($client['mobile'] != $mobile){
	    	$this->clientModel->update($cid, $data);
	    }

	    return 'success';
    }




}
