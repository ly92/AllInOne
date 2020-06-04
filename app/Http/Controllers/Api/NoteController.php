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
	private $tagService;

	public function __construct()
	{
		parent::__construct();
		$this->noteService = new NoteService();
	}


	/**
	 * @param Request $request
	 * @return array
	 */
	public function addNote(Request $request)
	{
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

	public function getCellType(Request $request)
	{
		$this->validateRequest($request->all(), [
			'cid' => 'required'
		]);
		$cid = $request->input('cid');
		$status = $request->input('status');
		$result = $this->noteService->getCellTypes($cid, $status);
		$this->setContent($result);
		return $this->response();
	}

	public function addCellType(Request $request)
	{
		$this->validateRequest($request->all(), [
			'cid' => 'required',
			'title' => 'required',
			'type' => 'required'
		]);

		$cid = $request->input('cid');
		$title = $request->input('title');
		$type = $request->input('type');
		$index = $request->input('index');

		$result = $this->noteService->addCellType($cid, $title, $type, $index);
		$this->setContent($result);
		return $this->response();
	}

	public function modifyCellType(Request $request)
	{
		$this->validateRequest($request->all(), [
			'cid' => 'required',
			'id' => 'required'
		]);

		$id = $request->input('id');
		$cid = $request->input('cid');
		$title = $request->input('title');
		$type = $request->input('type');
		$index = $request->input('index');
		$status = $request->input('status');

		$result = $this->noteService->modifyCellType($cid, $id, $title, $type, $index, $status);
		$this->setContent($result);
		return $this->response();
	}

	public function addCell(Request $request)
	{
		$this->validateRequest($request->all(), [
			'cid' => 'required',
			'nid' => 'required',
			'tid' => 'required',
			'num' => 'required'
		]);

		$cid = $request->input('cid');
		$nid = $request->input('nid');
		$tid = $request->input('tid');
		$presentation = $request->input('presentation');
		$address = $request->input('address');
		$num = $request->input('num');

		$result = $this->noteService->addCell($cid, $nid, $tid, $num, $presentation, $address);
	}

}
