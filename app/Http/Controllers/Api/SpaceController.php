<?php
/**
 * Created by PhpStorm.
 * User: zyw
 * Date: 2020/5/28
 * Time: 10:52 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Service\Space\SpaceService;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
	private $spaceService;
	public function __construct()
	{
		$this->spaceService = new SpaceService();
	}

	public function add(Request $request){

		$cid = $request->input('cid');
		$name = $request->input('name');
		$desc = $request->input('desc');

		$result = $this->spaceService->add($cid, $name, $desc);
	}

	public function addMember(Request $request){

		$sid = $request->input('sid');
		$mobiles = $request->input('mobiles');

		$result = $this->spaceService->addSpaceMember($sid, $mobiles);

	}

}