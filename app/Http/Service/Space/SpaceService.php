<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/27
 * Time: 2:24 下午
 */

namespace App\Http\Service\Space;

use App\Http\Model\Space\SpaceMemberModel;
use App\Http\Model\Space\SpaceModel;
use App\Http\Model\Space\SpaceNoteModel;
use App\Http\Service\BaseService;
use App\Http\Service\Client\ClientService;
use App\Http\Service\Note\NoteService;

class SpaceService extends BaseService
{
    private $spaceModel;
    private $spaceMemberModel;
    private $spaceNoteModel;

    public function __construct()
    {
        parent::__construct();
        $this->spaceModel = new SpaceModel();
        $this->spaceMemberModel = new SpaceMemberModel();
        $this->spaceNoteModel = new SpaceNoteModel();
    }

    /**
     * 新建空间
     * @param $cid
     * @param $name
     * @param $desc
     * @return int
     * @throws \Exception
     */
    public function add($cid, $name, $desc)
    {
        if (empty($name)) {
            $this->throwError('空间名称不可为空', 1001);
        }

        if (!empty($cid)) {
            $client = (new ClientService())->getById($cid);
            if (empty($client)) {
                $this->throwError('用户信息不存在', 1002);
            }
        } else {
            $this->throwError('缺少用户信息', 1002);
        }

        $id = $this->spaceModel->add([
            'cid' => $cid,
            'name' => $name,
            'presentation' => $desc,
            'creationTime' => time()
        ]);
        return $id;
    }

    /**
     * 添加空间成员
     * @param $sid
     * @param $mobiles
     * @return string
     * @throws \Exception
     */
    public function addSpaceMember($cid, $sid, $mobiles)
    {
        if (!empty($cid)) {
            $client = (new ClientService())->getById($cid);
            if (empty($client)) {
                $this->throwError('用户信息不存在', 1002);
            }
        } else {
            $this->throwError('缺少用户信息', 1002);
        }

        if (empty($sid) || empty($mobiles)) {
            $this->throwError('空间信息和成员信息不可为空', 1004);
        }
        $space = $this->spaceModel->getById($sid);
        if (empty($space)) {
            $this->throwError('空间信息不存在', 1005);
        }

        if ($space->cid != $cid){
            $this->throwError('无权操作', 1006);
        }

        $mobiles = explode(',', $mobiles);
        $data = [];
        foreach ($mobiles as $mobile) {
            $client = (new ClientService())->getByMobile($mobile);
            if ($client) {
                $temp = [
                    'sid' => $sid,
                    'cid' => $client->id,
                    'status' => 2,
                    'creationTime' => time()
                ];
                $data[] = $temp;
            }
        }
        if (count($data) > 0) {
            $this->spaceMemberModel->add($data);
        }
        return 'success';
    }

    /**
     * 空间成员
     * @param $sid
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     * @throws \Exception
     */
    public function getSpaceMembers($sid)
    {
        if (empty($sid)) {
            $this->throwError('空间信息不可为空', 1004);
        }
        $space = $this->spaceModel->getById($sid);
        if (empty($space)) {
            $this->throwError('空间信息不存在', 1007);
        }
        $members = $this->spaceMemberModel->getBySid($sid);
        $space['members'] = $members;
        return $space;
    }

    /**
     * 修改空间成员状态
     * @param $id
     * @param $status
     * @return string
     * @throws \Exception
     */
    public function updateSpaceMember($id, $status)
    {
        if (empty($id) || empty($status)) {
            $this->throwError('请求信息有误', 1005);
        }
        $spaceMember = $this->spaceMemberModel->getById($id, 0);
        if ($spaceMember['status'] != $status) {
            $result = $this->spaceMemberModel->update($id, [
                'status' => $status,
                'modifyTime' => time()
            ]);
            if (!$result) {
                $this->throwError('修改失败', 1002);
            }
        }
        return 'success';
    }

    /**
     * 参与的的空间,包含自己创建的空间
     * @param $cid
     * @param int $justOwner
     * @param int $status
     * @return array
     * @throws \Exception
     */
    public function getSpaces($cid, $justOwner = 0, $status = 1)
    {
        if (empty($cid)) {
            $this->throwError('缺少用户信息', 1002);
        }
        $client = (new ClientService())->getById($cid);
        if (empty($client)) {
            $this->throwError('用户信息不存在', 1002);
        }

        $spaces = $this->spaceModel->getSpaces($cid, $justOwner, $status);
        return $spaces;
    }


    /**
     * 添加空间笔记
     * @param $sid
     * @param $nid
     * @return int
     * @throws \Exception
     */
    public function addSpaceNote($sid, $nid)
    {
        if (empty($sid) || empty($nid)) {
            $this->throwError('空间信息和笔记信息不可为空', 1004);
        }
        $space = $this->spaceModel->getById($sid);
        if (empty($space)) {
            $this->throwError('空间信息不存在', 1005);
        }
        $note = (new NoteService())->getById($nid);
        if (empty($note)) {
            $this->throwError('笔记信息不存在', 1005);
        }
        if ($space['cid'] != $note['cid']) {
            $this->throwError('空间和笔记不属于同一用户', 1007);
        }
        $result = $this->spaceNoteModel->add([
            'sid' => $sid,
            'nid' => $nid
        ]);
        if (!$result) {
            $this->throwError('添加失败', 1002);
        }

        return 'success';
    }

    /**
     * 修改空间内笔记状态
     * @param $id
     * @param $status
     * @return string
     * @throws \Exception
     */
    public function updateSpaceNote($id, $status)
    {
        if (empty($id) || empty($status)) {
            $this->throwError('请求信息有误', 1005);
        }
        $spaceNote = $this->spaceNoteModel->getById($id, 0);
        if ($spaceNote['status'] != $status) {
            $result = $this->spaceNoteModel->update($id, [
                'status' => $status,
                'modifyTime' => time()
            ]);
            if (!$result) {
                $this->throwError('修改失败', 1002);
            }
        }
        return 'success';
    }

    /**
     * 空间内的笔记
     * @param $sid
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     * @throws \Exception
     */
    public function getSpaceNotes($sid)
    {
        if (empty($sid)) {
            $this->throwError('空间信息不可为空', 1004);
        }
        $space = $this->spaceModel->getById($sid);
        if (empty($space)) {
            $this->throwError('空间信息不存在', 1007);
        }
        $notes = $this->spaceNoteModel->getBySid($sid);
        $space['notes'] = $notes;
        return $space;
    }

}
