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

    public function addNote(Request $request){
        $this->validateRequest($request->all(), [
            'cid' => 'required',
            'title' => 'required',
            'type' => 'required'
        ]);

        $result = $this->noteService->add


    }
}
