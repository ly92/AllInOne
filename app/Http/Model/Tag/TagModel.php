<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:11 下午
 */

namespace App\Http\Model\Tag;

use App\Http\Model\BaseModel;
use Illuminate\Support\Facades\DB;

class TagModel extends BaseModel
{
	public static $table = 'aio_tag';
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * @param $data
	 * @return int
	 */
    public function add($data){
    	return DB::table(self::$table)->insertGetId($data);
    }

	/**
	 * @param $id
	 * @param $data
	 * @return int
	 */
    public function modify($id, $data){
    	return DB::table(self::$table)->where('id', $id)->update($data);
    }

	/**
	 * 获取某人的标签
	 * @param $cid
	 * @param string $title
	 * @param int $status
	 * @return array
	 */
	public function search($cid, $title = '', $status = 1){
    	$db = DB::table(self::$table)->where('cid', $cid);
    	if (!empty($title)){
    		$db->where('title', 'like', '%' . $title . '%');
	    }
	    if (!empty($status)){
    		$db->where('status', $status);
	    }
	    return $db->get()->toArray();
	}

	/**
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Model|null|object|static
	 */
	public function getById($id){
		return DB::table(self::$table)->where('id', $id)->first();
	}
}
