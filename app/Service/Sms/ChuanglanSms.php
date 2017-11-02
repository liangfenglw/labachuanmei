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
 * 创蓝短信类
 * @author        forapply <for_apply@qq.com>
 * @create        2017/2/14
 * @description   短信类，主要功能：发送短信，查询余额等
 * @version       v1.0.0
 * @copyright (c) 2017,广州花镇
 * 
 */
use helpers;
use Log;
use App\Service\Sms\SmsSendApi;
class ChuanglanSms {

    const API_SEND_URL = 'http://sms.253.com/msg/send';
    //创蓝短信余额查询接口URL
    const API_BALANCE_QUERY_URL = 'http://sms.253.com/msg/balance';
    const API_ACCOUNT = 'M3424602';
    const API_PASSWORD = 'ebpX7hL1Qmbb74';

	/**
	 * 初始化账号密码
	 */
	public function __construct() {
		// self::$API_ACCOUNT = env('SMS_API_ACCOUNT');
		// self::$API_PASSWORD = env('SMS_API_PWD');
	}

	/**
	 * 发送短信
	 *
	 * @param string $mobile 		手机号码
	 * @param string $msg 			短信内容
	 * @param string $needstatus 	是否需要状态报告 1返回状态 0不需要
	 */
	public function sendSMS($postData) {
		$postArr = ['un' => self::API_ACCOUNT,
					'pw' => self::API_PASSWORD,
					'rd' => 1,
					];
		foreach ($postData as $key => $value) {
			if (in_array($key, ['msg','mobile'])) {
				$postArr[$key] = $value;
			}
		}
		$postArr['phone'] = $postArr['mobile'];
		unset($postArr['mobile']);
		$result = SmsSendApi::curlPost(self::API_SEND_URL,$postArr);
		$result = $this->execResMsg($result);//返回错误信息
		return $result;
	}

	/**
	 * 查询额度
	 */
	public function queryBalance() {
		$postArr = ['un' => self::$API_ACCOUNT,'pw' => self::$API_PASSWORD];
		$result = $this->curlPost(self::API_BALANCE_QUERY_URL, $postArr);
		return $result;
	}

	/**
	 * 返回错误信息
	 * @param  [type] $result 发送结果
	 * @return [type]         [description]
	 */
	public function execResMsg($result) {
		$errNum = $this->execResult($result);
		$errMsg = $this->errorMsg($errNum['1']);
		if ($errNum['1'] == '0') { //成功
			return ['status_code' => 200];
		}
		return ['status_code' => $errNum['1'], 'msg'=> $errMsg];
	}

	/**
	 * 处理返回值
	 * 
	 */
	public function execResult($result){
		$result=preg_split("/[,\r\n ]/",$result);
		return $result;
	}

	/**
	 * 返回错误信息
	 * @param  [type] $errNum 错误码
	 * @return [type]         [description]
	 */
	public function errorMsg($errNum) {
		$errMsg = ['0' => '提交成功',
				   '101' => '无此用户',
				   '102' => '密码错',
				   '103' => '提交过快（提交速度超过流速限制',
				   '104' => '系统忙（因平台侧原因，暂时无法处理提交的短信）',
				   '105' => '敏感短信（短信内容包含敏感词)',
				   '106' => '消息长度错（>536或<=0)',
				   '107' => '包含错误的手机号码',
				   '108' => '手机号码个数错（群发>50000或<=0）',
				   '109' => '无发送额度（该用户可用短信数已使用完）',
				   '110' => '不在发送时间内',
				   '113' => 'extno格式错（非数字或者长度不对）',
				   '116' => '签名不合法或未带签名（用户必须带签名的前提下）',
				   '117' => 'IP地址认证错,请求调用的IP地址不是系统登记的IP地址',
				   '118' => '用户没有相应的发送权限（账号被禁止发送）',
				   '119' => '用户已过期',
				   '120' => '违反放盗用策略(日发限制) --自定义添加',
				   '121' => '必填参数。是否需要状态报告，取值true或false',
				   '122' => '5分钟内相同账号提交相同消息内容过多',
				   '123' => '发送类型错误',
				   '124' => '白模板匹配错误',
				   '125' => '驳回模板匹配错误',
				   '128' => '内容解码失败'
				];
		return $errMsg[$errNum];
	}
	
	//魔术获取
	public function __get($name){
		return $this->$name;
	}
	
	//魔术设置
	public function __set($name,$value){
		$this->$name=$value;
	}
}
?>