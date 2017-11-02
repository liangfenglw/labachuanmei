<?php
/**
 * 我的客户
 * @author: liang <liangcb@pv.cc>
 * @date: 2017-01-12
 */
namespace App\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class SmsService extends CommonService
{

    /*
     * 根据手机号获取资源ID
     */
    public function getRid($tel)
    {
       return DB::table('one_resource')->where('telphone',$tel)->value('id');
    }

    /**
     * 根据手机号获取phone_code
     */
    public function getPhoneCode($tel)
    {
        return DB::table('one_resource')->where('telphone',$tel)->value('phone_code');
    }

    /**
     * 短信发送状态报告推送
     */
    public function addSmsPushStatusLog($data)
    {
        try {
            return DB::table('one_sms_pushstatus_log')->insertGetId($data);
        } catch (Exception $e) {
            Log::info('短信发送状态报告推送添加出错：'.$e->getMessage());
            return false;
        }
    }

    /**
     * 更新资源表的phone_code和phone_type
     * @param int $rid 资源ID
     */
    public function updateRes($rid,$data)
    {
        return DB::table('one_resource')->where('id',$rid)->update($data);
    }


    /**
     * 短信回复
     * @param array $data 要入库的数据
     */
    public function addSmsReply($data)
    {
        return DB::table('one_sms_reply')->insertGetId($data);
    }
}
