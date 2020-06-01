<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:18 下午
 */

namespace App\Http\Model\Note;

use App\Http\Model\BaseModel;
use Illuminate\Support\Facades\DB;

class NoteTagModel extends BaseModel
{
	public static $table = 'aio_note_tag';
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * @param $data
	 * @return bool
	 */
    public function add($data){
    	return DB::table(self::$table)->insert($data);
    }


}
