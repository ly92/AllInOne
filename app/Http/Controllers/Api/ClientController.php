<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 2020/5/28
 * Time: 4:39 下午
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{


    public function register(Request $request)
    {

        return '123111';
        $validatedData = $request->validate([
            'mobile' => 'required|min:11|max:11',
            'name' => 'required',
            'password' => 'required'
        ]);

        return '1231';
        dd($validatedData);
    }
}
