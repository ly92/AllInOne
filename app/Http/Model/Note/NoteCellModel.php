<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:16 下午
 */

namespace App\Http\Model\Note;

use App\Http\Model\BaseModel;
use Illuminate\Support\Facades\DB;

class NoteCellModel extends BaseModel
{
	public static $table = 'aio_note_cell';
	public static $typeTable = 'aio_note_cell_type';

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data){
    	return DB::table(self::$table)->insertGetId($data);
    }

    public function addType($data){
	    return DB::table(self::$typeTable)->insertGetId($data);
    }

    public function getTypes($cid, $status = 1){
    	$db = DB::table(self::$typeTable)->where('cid', $cid);
    	if (!empty($status)){
    		$db->where('status', $status);
	    }
	    return $db->get()->toArray();
    }

    public function getTypeById($id, $status = 0){
	    $db = DB::table(self::$typeTable)->where('id', $id);
	    if (!empty($status)){
		    $db->where('status', $status);
	    }
	    return $db->first();
    }

	public function getTypeByTitle($title, $status = 0){
		$db = DB::table(self::$typeTable)->where('title', $title);
		if (!empty($status)){
			$db->where('status', $status);
		}
		return $db->first();
	}

    public function modifyType($id, $data){
    	return DB::table(self::$typeTable)->where('id', $id)->update($data);
    }
}
