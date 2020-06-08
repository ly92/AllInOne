<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


/** @var TYPE_NAME $router */
$router->get('/', function () use ($router) {
	return $router->app->version();
});


$router->post('/register', "Api\ClientController@register");
$router->post('/login', "Api\ClientController@login");


$router->group(['middleware' => 'auth', 'namespace' => 'Api', 'prefix' => 'api'], function () use ($router) {


	/*************************** 空间 ****************************/


	/*************************** 空间 ****************************/

	//添加空间
	$router->post('/space/add', "SpaceController@add");

	//获取空间列表
	$router->post('/space/spaces', "SpaceController@getSpaces");

	//空间添加成员
	$router->post('/space/addMember', "SpaceController@addMember");

	/*************************** 标签 ****************************/
	//添加标签
	$router->post('/tag/add', "TagController@add");

	//修改标签
	$router->post('/tag/modify', "TagController@modify");

	//标签列表
	$router->post('/tag/aearch', "TagController@searchTags");


	/*************************** 笔记 ****************************/
	//添加日记
	$router->post('/note/add', "NoteController@addNote");

	//获取日记cell类别
	$router->post('/note/cellType', "NoteController@getCellType");

	//添加日记cell类别
	$router->post('/note/addCellType', "NoteController@addCellType");

	//修改日记cell类别
	$router->post('/note/modifyCellType', "NoteController@modifyCellType");

	//增加日记cell
	$router->post('/note/addCell', "NoteController@addCell");


});
