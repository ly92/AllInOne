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
}
