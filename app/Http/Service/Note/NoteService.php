<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:23 下午
 */

namespace App\Http\Service\Note;

use App\Http\Model\Note\NoteCellModel;
use App\Http\Model\Note\NoteModel;
use App\Http\Model\Note\NoteTagModel;
use App\Http\Service\BaseService;
use App\Http\Service\Client\ClientService;

class NoteService extends BaseService
{
	private $noteModel;
	private $noteTagModel;
	private $noteCellModel;

	public function __construct()
	{
		parent::__construct();
		$this->noteModel = new NoteModel();
		$this->noteTagModel = new NoteTagModel();
		$this->noteCellModel = new NoteCellModel();
	}

	public function add($cid, $title, $type = 1, $subTitle = '', $content = '', $sid = 0, $tags = '')
	{
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息无效', 1002);
		}
		if (empty($title)) {
			throw new \Exception('请输入笔记标题', 1003);
		}

		$data = [
			'cid' => $cid,
			'title' => $title,
			'type' => $type,
			'creationTime' => time()
		];
		if (!empty($subTitle)) {
			$data['subTitle'] = $subTitle;
		}
		if (!empty($content)) {
			$data['content'] = $content;
		}
		if (!empty($sid)) {
			$data['sid'] = $sid;
		}
		//新增笔记
		$id = $this->noteModel->add($data);

		//记录标签
		if ($id && !empty($tags)) {
			$tags = explode(',', $tags);
			$tempData = [];
			foreach ($tags as $tag){
				$tempData[] = [
					'nid' => $id,
					'tid' => $tag,
					'creationTime' => time()
				];
			}
			if (!empty($tempData)){
				$this->noteTagModel->add($data);
			}
	    }

		return $id;
	}



	public function getCellTypes($cid, $status = 1){
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息无效', 1002);
		}
		$list = $this->noteCellModel->getTypes($cid, $status);
		return $list;
	}

	public function addCellType($cid, $title, $type, $index){
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息无效', 1002);
		}
		$cellType = $this->noteCellModel->getTypeByTitle($title);
		if ($cellType){
			$this->noteCellModel->modifyType($cellType['id'], [
				'title' => $title,
				'type' => $type,
				'index' => $index,
				'modifyTime' => time()
			]);
			return $cellType['id'];
		}else{
			$id = $this->noteCellModel->addType([
				'cid' => $cid,
				'title' => $title,
				'type' => $type,
				'index' => $index,
				'creationType' => time()
			]);
		}

	}

	public function modifyCellType($cid, $id, $title, $type, $index, $status){
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息无效', 1002);
		}
		$cellType = $this->noteCellModel->getTypeById($id);
		if (empty($cellType) || $cellType['cid'] != $cid){
			throw new \Exception('不可修改', 2001);
		}

		$data = [];
		if (!empty($title)){
			$data['title'] = $title;
		}
		if (!empty($type)){
			$data['type'] = $type;
		}
		if (!empty($index)){
			$data['index'] = $index;
		}
		if (!empty($status)){
			$data['status'] = $status;
		}

		if (empty($data)){
			return 'success';
		}

		$result = $this->noteCellModel->modifyType($id, $data);
		return $result;
	}


	public function addCell($cid, $nid, $tid, $num, $presentation, $address){
		$client = (new ClientService())->getById($cid);
		if (empty($client)) {
			throw new \Exception('用户信息无效', 1002);
		}
		$note = $this->noteModel->getById($nid);


	}
}
