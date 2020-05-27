<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:14 下午
 */

namespace App\Http\Model\Space;


use App\Http\Model\BaseModel;
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
        return DB::table(self::$atble)->insertGetId($data);
    }

    /**
     * 获取信息
     * @param $id
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getById($id, $status = 1){
        return DB::table(self::$table)->where('id', $id)->where('status', $status)->first();
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
