<?php
namespace Index\Controller;
use Think\Controller;
class TebiaController extends Controller {

    public function index() {
        // $this->replayType('复制这条信息，打开手机淘宝即可看到【诺希正品iPhone6电池iPhone5s苹果7手机6s六6 plus大容量6sp电板】￥keAIGSC7Uj￥http://e22a.com/h.sSXitD?cv=keAIGSC7Uj&sm=8987f4');
        // die();
        include(  __ROOT__ ."ThinkPHP/Library/Vendor/Wechat.class.php");
        $options = array(
            'token'=>'dataoke12345' //填写你设定的key
        );
        $weObj = new \Wechat($options);
        $weObj->valid();
        $type = $weObj->getRev()->getRevType();
        switch($type) {
            case \Wechat::MSGTYPE_TEXT:
                    $weObj->news( $this->replayType( $weObj->getRevContent() ) )->reply();
                    exit;
                    break;
            case \Wechat::MSGTYPE_EVENT:
                    break;
            case \Wechat::MSGTYPE_IMAGE:
                    $weObj->text("抱歉,我还不能识别图片哦，不能和你斗图啦")->reply();
                    exit;
                    break;
            default:
                    $weObj->text("help info")->reply();
        }
    }

    
}