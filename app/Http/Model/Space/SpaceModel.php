<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:07 下午
 */

namespace App\Http\Model\Space;

use App\Http\Model\BaseModel;
use App\Http\Model\Note\NoteModel;
use Illuminate\Support\Facades\DB;

class SpaceModel extends BaseModel
{
    public static $table = 'aio_space';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 添加空间
     * @param $data
     * @return int
     */
    public function add($data)
    {
        return DB::table(self::$table)->insertGetId($data);
    }

    /**
     * 获取信息
     * @param $id
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getById($id, $status = 1)
    {
        return DB::table(self::$table)->where('id', $id)->where('status', $status)->first();
    }

    /**
     * 修改信息
     * @param $id
     * @param $data
     * @return int
     */
    public function update($id, $data)
    {
        return DB::table(self::$table)->where('id', $id)->update($data);
    }

    /**
     * 参与的的空间,包含自己创建的空间
     * @param $cid
     * @param int $justOwner
     * @param int $status
     * @return array
     */
    public function getSpaces($cid, $justOwner = 0, $status = 1)
    {
        $db = DB::table(self::$table . ' as a')
            ->leftJoin(NoteModel::$table . ' as b', 'a.id', '=', 'b.sid')
            ->leftJoin(SpaceMemberModel::$table . ' as c', 'a.id', '=', 'c.sid');
        if (!empty($status)){
        	$db->where('a.status', $status);
        }
        if ($justOwner) {
            $db->where('a.cid', $cid);
        } else {
            $db->where( function($query) use ($cid) {
                $query->where('c.cid', $cid)
                    ->orWhere('a.cid', $cid);
            });
        }
        return $db->selectRaw('a.*, count(c.id) + 1 as memberCount, count(b.id) as noteCount, IF(a.cid=?, 1, 0) AS
        owner', [$cid])
            ->groupBy('a.id')->orderBy('owner', 'desc')
            ->get()->toArray();
    }

}
