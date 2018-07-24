<?php
/**
 * Created by PhpStorm.
 * User: lvxinxin
 * Date: 2018/07/20
 * Email: lx.xin@qq.com
 */

namespace Lxin87\Alidysms;

use Lxin87\Alidysms\Builder;
class AliSmsService {
    //手机号码
    protected $phone;
    //短信内容
    protected $templateParam;
    //模板签名
    protected $signName;
    //短信模板编号
    protected $templateCode;

    /**
     * AliSmsService constructor.
     */
    public function __construct()
    {
        $this->signName = config('sms.sign_name');
        $this->templateCode = config('sms.template_code');
    }

    /**
     * @param $key
     * @param $val
     *
     * @return $this
     */
    public function set($key,$val){
        $this->$key = $val;
        return $this;
    }

    public function send(){
        $response = Builder::sendSms(
            $this->phone,
            $this->signName,
            $this->templateCode,
            $this->templateParam
        );

        \Log::info('ali.sms.send.log',[$response]);
        if($response->Code = 'OK'){
            return true;
        }
        return false;
    }

    public function batchSend(){
        $response = Builder::sendBatchSms(
            $this->phone,
            $this->signName,
            $this->templateCode,
            $this->templateParam
        );

        \Log::info('ali.sms.batch.send.log',[$response]);
        if($response->Code = 'OK'){
            return true;
        }
        return false;
    }

    public function query(){
        //TODO:: ali send sms log query
        exit(__METHOD__);
    }

}