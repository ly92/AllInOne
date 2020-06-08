<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:14 下午
 */

namespace App\Http\Model\Space;


use App\Http\Model\BaseModel;
use App\Http\Model\Client\ClientModel;
use Illuminate\Support\Facades\DB;

class SpaceMemberModel extends BaseModel
{
    public static $table = 'aio_space_member';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 添加空间成员
     * @param $data
     * @return int
     */
    public function add($data){
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 获取信息
     * @param $id
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getById($id, $status = 1){
    	if ($status){
		    return DB::table(self::$table)->where('id', $id)->where('status', $status)->first();
	    }
	    return DB::table(self::$table)->where('id', $id)->first();
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

    /**
     * 空间的成员
     * @param $sid
     * @param int $status
     * @return array
     */
    public function getBySid($sid, $status = 1){
        return DB::table(self::$table . ' as a')
            ->leftJoin(ClientModel::$table . ' as b', 'a.cid', '=', 'b.id')
            ->where('a.sid', $sid)->where('a.status', $status)
            ->select('a.cid', 'b.name', 'b.mobile')
            ->get()->toArray();
    }

}
