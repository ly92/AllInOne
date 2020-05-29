<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{


    public function __construct()
    {
    }


    /**
     * 请求参数验证相关
     */
    private function getValidateMessages(){
        return [
            'required' => '[:attribute]' . ' 为必填项',
            'max' => '[:attribute]' . ' 超出允许最大值',
            'min' => '[:attribute]' . ' 超出允许最小值',
            'in' => '[:attribute]' . ' 无效',
            'numeric' => '[:attribute]' . ' 须要为数值',
            'array' => '[:attribute]' . ' 期望值为数组'
        ];
    }

    public function validateRequest(array $params, array $rules)
    {
        $validator = Validator::make($params, $rules, $this->getValidateMessages());
        $result = '';
        if ($validator->fails()){
            $errors = $validator->errors()->all();
            $result = implode(',', $errors);
        }

        if (!empty($result)){
            throw new \Exception($result, 9999);
        }
        return $result;
    }


    /**
     * 返回数据相关
     */
    private $content = [];
    private $message = '';
    private $statusCode = 200;
    private $code = 0;

    public function setContent($content)
    {
        if (is_array($content)) {
            $this->content = $content;
        }
        if (is_string($content)) {
            $this->content = ['result' => $content];
        }
    }

    public function setCodeAndMessage($code, $message)
    {
        $this->code = (int)$code;
        $this->message = $message;
    }

    public function setStatusCode($code)
    {
        $this->statusCode = (int)$code;
    }

    public function response()
    {
        return [
            'sttausCode' => $this->statusCode,
            'code' => $this->code,
            'content' => $this->content,
            'message' => $this->message
        ];
    }


}
