<?php
date_default_timezone_set('Asia/Shanghai'); 
include("../os.php");
$url =  getPayUrl();
$pay_url =platPay($_POST,$url);
header('Location:'.$pay_url);
exit();

function getPayUrl() {
        $url_s = 'http://beibaolvyou.cn/jeesite/gate/getPayUrl';
        $data['mchno'] =  '10079';
        $data['password'] = '147258';
        $data['sign'] = md5($data['mchno'].$data['password'].'GHYTA202D64C54771D11495625AABTYU' );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_s);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        $res = json_decode($result);
        if ($res->status) {
            return $res->payUrl;
        } else {
            return false;
        }
    }
function platPay($param,$url)
{
    $mchno = '10079';
    $userKey = 'GHYTA202D64C54771D11495625AABTYU';
    $pay_url = $url;

    $nonceStr = create_uuid();

    $data = [];
    $type = "order by rand() limit 1";
    $urlpeizhi = queryall('tzurl', $type);

    $data['mchno'] = $mchno;
    $data['outTradeNo'] = date("ymdHis").md5( date("ymdHis") );
    $data['money'] = (intval($param['ubomoney'])*95);
    $data['body'] = "VIP";
    $data['nonceStr'] = $nonceStr;
    $data['notifyUrl'] = 'http://45.119.98.121/pay/ptest.php';
    $data['returnUrl'] = urlencode("http://".$urlpeizhi['tzurl']."/jq.php");
    $data['attach'] = $_POST['ubopid'].'|'.$_POST['ubouid'];
    $data['payTime'] = date("Y-m-d H:m:s");

    $signature =  $data['mchno'].$data['outTradeNo'].$data['money'].$data['nonceStr'].$userKey;
    $data['sign'] = md5($signature);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $pay_url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($curl);
    $Headers  =  curl_getinfo($curl);
    curl_close($curl);
    return $Headers["redirect_url"];

}


function create_uuid($prefix = ""){    //可以指定前缀
    $str = md5(uniqid(mt_rand(), true));   
    $uuid  = substr($str,0,8) . '-';   
    $uuid .= substr($str,8,4) . '-';   
    $uuid .= substr($str,12,4) . '-';   
    $uuid .= substr($str,16,4) . '-';   
    $uuid .= substr($str,20,12);   
    return $prefix . $uuid;
}

?>