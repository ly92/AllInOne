<?php
/**
 * Created by PhpStorm.
 * User: zyw
 * Date: 2020/6/2
 * Time: 11:15 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Service\Tag\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
	private $tagService;
	public function __construct()
	{
		parent::__construct();
		$this->tagService = new TagService();
	}

	/**
	 * 可用标签
	 * @param Request $request
	 * @return array
	 */
	public function searchTags(Request $request){
		$this->validateRequest($request->all(), [
			'cid' => 'required'
		]);

		$cid = $request->input('cid');
		$result = $this->tagService->search($cid);
		$this->setContent($result);
		return $this->response();
	}

	public function add(Request $request){
		$this->validateRequest($request->all(), [
			'cid' => 'required',
			'title' => 'required',
			'color' => 'required'
		]);

		$cid = $request->input('cid');
		$title = $request->input('title');
		$color = $request->input('color');

		$result = $this->tagService->add($cid, $title, $color);
		$this->setContent($result);
		return $this->response();
	}

	public function modify(Request $request){
		$this->validateRequest($request->all(), [
			'cid' => 'required',
			'id' => 'require',
		]);
		$cid = $request->input('cid');
		$id = $request->input('id');
		$title = $request->input('title');
		$color = $request->input('color');
		$status = $request->input('status');

		$result = $this->tagService->modify($cid, $id, $title, $color, $status);
		$this->setContent($result);
		return $this->response();
	}
}