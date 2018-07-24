<?php
/**
 * Created by PhpStorm.
 * User: lvxinxin
 * Date: 2018/07/20
 * Email: lx.xin@qq.com
 */

return [
    #id
    'access_key_id'=>env('ACCESS_KEY_ID',''),
    #密钥
    'access_key_secret'=>env('ACCESS_KEY_SECRET',''),
    #产品
    'product'=>'Dysmsapi',
    #域名
    'domain'=>'dysmsapi.aliyuncs.com',
    #节点 cn-hangzhou | cn-shanghai | cn-beijing | cn-shenzhen
    'region'=>'cn-shanghai',
    #短信签名
    'sign_name'=>'',
    #模板编号
    'template_code'=>'',

//    'setting'=>[
//        'default'=>[
//            #短信签名
//            'sign_name'=>'',
//            #模板编号
//            'template_code'=>'',
//        ],
//
//
//    ],

];