<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index() {
        $options = array(
            'token'=>'tokenaccesskey', //填写你设定的key
            'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
            'appid'=>'wxe5fffe447fecd5f4', //填写高级调用功能的app id
            'appsecret'=>'f9e14444bad01ce940c50762637310fa' //填写高级调用功能的密钥
        );
        $weObj = new \Org\Wechat\TPWechat($options);
        $weObj->valid();
    }

}