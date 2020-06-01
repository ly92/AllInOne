<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/6/1
 * Time: 1:45 下午
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Service\Note\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private $noteService;
    public function __construct()
    {
        parent::__construct();
        $this->noteService = new NoteService();
    }

	/**
	 * @param Request $request
	 * @return array
	 */
    public function addNote(Request $request){
        $this->validateRequest($request->all(), [
            'cid' => 'required',
            'title' => 'required',
            'type' => 'required'
        ]);

        $cid = $request->input('cid');
        $title = $request->input('title');
        $type = $request->input('type');
        $subTitle = $request->input('subTitle');
        $content = $request->input('content');
        $tags = $request->input('tags');
        $sid = $request->input('sid');
        $result = $this->noteService->add($cid, $title, $type, $subTitle, $content, $sid, $tags);
        $this->setContent($result);
        return $this->response();
    }


    public function addCell(Request $request){
    	$this->validateRequest($request->all(), [
    		'cid' => 'required',
		    'nid' => 'required',
		    'title' => 'required',
		    'type' => 'required',
		    'num' => 'required'
	    ]);

    	$cid = $request->input('cid');
    	$nid = $request->input('nid');
    	$title = $request->input('title');
    	$type = $request->input('type');
    	$num = $request->input('num');

    }

}
