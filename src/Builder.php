<?php
/**
 * Created by PhpStorm.
 * User: lvxinxin
 * Date: 2018/07/20
 * Email: lx.xin@qq.com
 */

namespace Lxin87\Alidysms;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

// 加载区域结点配置
Config::load();

class Builder {


    /**
     * 初始化请求
     * @return mixed
     */
    public static function getAscClient(){
        $product = config('sms.product');
        $domain = config('sms.domain');
        $accessKeyId = config('sms.access_key_id');
        $accessKeySecret = config('sms.access_key_secret');
        $region = config('sms.region');
        $endPointName = config('sms.region');

        //初始化acsClient,暂不支持region化
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

        // 增加服务结点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

        // 初始化AcsClient用于发起请求
        return new DefaultAcsClient($profile);

    }

    /**
     * @param      $mobile 手机号
     * @param      $sign_name 签名
     * @param      $template_code  模板ID
     * @param null $template_param 模板参数
     * @param null $outId 自定义流水号
     *
     * @return mixed
     */
    public static function sendSms($mobile,$sign_name,$template_code,$template_param = null,$outId = null) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($mobile);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($sign_name);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($template_code);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        if($template_param){
            $request->setTemplateParam(json_encode($template_param, JSON_UNESCAPED_UNICODE));
        }
        if($outId){
            // 可选，设置流水号
            $request->setOutId("yourOutId");
        }
        // 发起访问请求
        $acsResponse = static::getAscClient()->getAcsResponse($request);

        return $acsResponse;
    }

    public static function sendBatchSms($mobileArr,$sign_nameArr,$template_code,$template_param) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendBatchSmsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumberJson(json_encode($mobileArr,JSON_UNESCAPED_UNICODE));

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignNameJson(json_encode($sign_nameArr,JSON_UNESCAPED_UNICODE));

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($template_code);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode($template_param, JSON_UNESCAPED_UNICODE));

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }

    /**
     * 查询短信发送情况范例
     *
     * @param string $phoneNumbers 必填, 短信接收号码 (e.g. 12345678901)
     * @param string $sendDate 必填，短信发送日期，格式Ymd，支持近30天记录查询 (e.g. 20170710)
     * @param int $pageSize 必填，分页大小
     * @param int $currentPage 必填，当前页码
     * @param string $bizId 选填，短信发送流水号 (e.g. abc123)
     * @return stdClass
     */
    public static function queryDetails($phoneNumbers, $sendDate, $pageSize = 10, $currentPage = 1, $bizId=null)
    {
        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();
        // 必填，短信接收号码
        $request->setPhoneNumber($phoneNumbers);
        // 选填，短信发送流水号
        $request->setBizId($bizId);
        // 必填，短信发送日期，支持近30天记录查询，格式Ymd
        $request->setSendDate($sendDate);
        // 必填，分页大小
        $request->setPageSize($pageSize);
        // 必填，当前页码
        $request->setCurrentPage($currentPage);
        // 发起访问请求
        $acsResponse = static::getAscClient()->getAcsResponse($request);
        // 打印请求结果
        // var_dump($acsResponse);
        return $acsResponse;
    }


}