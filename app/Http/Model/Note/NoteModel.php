<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:11 下午
 */

namespace App\Http\Model\Note;

use App\Http\Model\BaseModel;
use Illuminate\Support\Facades\DB;

class NoteModel extends BaseModel
{
	public static $table = 'aio_note';
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

}
