<?php
namespace App\Service\Sms;
/*
| -------------------------------------------------------------------------- 
| 
|
| Copyright (C) 2017 GuangZhou huazhen Information Science & Technology Co.,Ltd. 
| All rights reserved.
|
| Authors:
|       forapply <for_apply@qq.com>
|      
| This software, including documentation, is protected by copyright 
| controlled by GuangZhou huazhen Information Science & Technology Co.,Ltd. 
| All rights are reserved.
| 
| --------------------------------------------------------------------------  
*/

/**
 * 短信类
 * @author        forapply <for_apply@qq.com>
 * @create        2017/2/15
 * @description   短信接口
 * @version       v1.0.0
 * @copyright (c) 2017,广州花镇
 * 
 */
use helpers;
use Log;
use App\Service\Sms\ChuanglanSms;

class SmsSendApi {

	/**
	 * 初始化账号密码
	 */
	public function __construct() {
		// self::$API_ACCOUNT = env('SMS_API_ACCOUNT');
		// self::$API_PASSWORD = env('SMS_API_PWD');
	}

	/**
	 * 发送短信
	 * @param  String $serviceName 服务商类
	 * @param  Array  $postData    发送内容
	 * @return
	 */
	public static function sendSms($serviceName,$postData) {
		$class = new \ReflectionClass('App\Service\Sms\\'.$serviceName);
		$serviceClass  = $class->newInstance();
		$res = $serviceClass->sendSMS($postData,1);
		if ($res['status_code'] == '200') { //成功
			return true;
		} else {
			//记录错误信息
			Log::error('短信发送失败', ['mobile' => $postData['phone'], 'errMsg' => $res['msg'],'content'=>$postData['msg']]);
		}
	}

	/**
	 * 查询余额
	 * @return [type] [description]
	 */
	public function queryBalance() {

	}

    /**
     * 状态报告推送
     */
    public function getSmsStatus()
    {
        
    }

	/**
	 * 通过CURL发送HTTP请求
	 * @param string $url  //请求URL
	 * @param array $postFields //请求参数 
	 * @return mixed
	 */
	public static function curlPost($url,$postFields){
		$postFields = http_build_query($postFields);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}

}
?>