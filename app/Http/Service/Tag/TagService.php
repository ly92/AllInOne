<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:24 下午
 */

namespace App\Http\Service\Tag;

use App\Http\Model\Tag\TagModel;
use App\Http\Service\BaseService;
use App\Http\Service\Client\ClientService;

class TagService extends BaseService
{
	private $tagModel;

	public function __construct()
	{
		parent::__construct();
		$this->tagModel = new TagModel();
	}

	/**
	 * @param $cid
	 * @param string $title
	 * @param int $status
	 * @return array
	 * @throws \Exception
	 */
	public function search($cid, $title = '', $status = 1)
	{
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息不存在', 1002);
		}
		$list = $this->tagModel->search($cid, $title, $status);
		return $list;
	}

	/**
	 * @param $cid
	 * @param $title
	 * @param $color
	 * @return int
	 * @throws \Exception
	 */
	public function add($cid, $title, $color)
	{
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息不存在', 1002);
		}

		$tag = $this->tagModel->getByTitle($title);
		if ($tag){
			$this->tagModel->modify($tag['id'], [
				'status' => 1,
				'color' => $color,
				'modifyTime' => time()
			]);
		}else{
			$id = $this->tagModel->add([
				'cid' => $cid,
				'title' => $title,
				'color' => $color,
				'creationTime' => time()
			]);
			return $id;
		}
	}

	/**
	 * @param $cid
	 * @param $id
	 * @param string $title
	 * @param string $color
	 * @param int $status
	 * @return int|string
	 * @throws \Exception
	 */
	public function modify($cid, $id, $title = '', $color = '', $status = 0)
	{
		$tag = $this->tagModel->getById($id);
		if (empty($tag) || $tag['cid'] != $cid) {
			throw new \Exception('不允许修改', 1003);
		}
		$data = [];
		if (!empty($title)) {
			$data['title'] = $title;
		}
		if (!empty($color)) {
			$data['color'] = $color;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}

		if (!empty($data)) {
			$result = $this->tagModel->modify($id, $data);
		} else {
			$result = 'success';
		}
		return $result;
	}
}
