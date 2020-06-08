<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:11 下午
 */


namespace App\Http\Model\Client;

use App\Http\Model\BaseModel;
use Illuminate\Support\Facades\DB;

class ClientModel extends BaseModel
{
    public static $table = 'aio_client';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取用户信息
     * @param $id
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getById($id, $status = 1){
        return DB::table(self::$table)->where('id', $id)->where('status', $status)->first();
    }

    /**
     * 获取用户信息
     * @param $mobile
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getByMobile($mobile, $status = 1){
        $db = DB::table(self::$table)->where('mobile', $mobile)->where('status', $status)->first();
        return $db;
    }

    /**
     * 添加用户
     * @param $data
     * @return int
     */
    public function add($data){
        return DB::table(self::$table)->insertGetId($data);
    }

    /**
     * 修改信息
     * @param $id
     * @param $data
     * @return int
     */
    public function update($id, $data){
        return DB::table(self::$table)->where('id', $id)->update($data);
    }

}
