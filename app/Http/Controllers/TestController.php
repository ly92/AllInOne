<?php
/**
 * Created by PhpStorm.
 * User: zyw
 * Date: 2020/8/30
 * Time: 11:29 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

class TestController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function test(Request $request){



		$hosts = ['https://door:door123456@47.95.145.227:9200'];
		// $hosts = ['https://elastic:Super@123@47.95.145.227:9200'];
		// $myCert = storage_path() . '/cert/elastic-ca.pem';
		// $myCrt = storage_path() . '/cert/ca/ca.crt';
		// $myKey = storage_path() . '/cert/ca/ca.key';
		//
		//
		// $client = ClientBuilder::create()
		// 	->setHosts($hosts)
		// 	// ->setSSLCert($myCrt)
		// 	// ->setSSLKey($myKey)
		// 	->setSSLVerification($myCert)
		// 	->build();

		$client = ClientBuilder::create()
			->setHosts($hosts)
			->setApiKey('91zrP3QB2MvtWW9wg0n-', 'AtAX8oKZSeqj94dbR27ATQ')
			->build();

		$params = [
			'index' => 'program',
			'id'    => '1'
		];

		$result = $client->get($params);

		$this->setContent($result);
		return $this->response();
	}

}