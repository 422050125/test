<?php
/**
 * User: fangjinwei
 * Date: 2017/06/16 23:06
 * Desc: 测试
 */

class TestController extends Controller {
    public $redis;

    public function __construct()
    {
        parent::__construct();

        //$this->redis = new RedisCacheExt();

    }

    //swoole和workerman
    public function index(){
        switch ( $this->get['type'] ){
            case 'statisticMonitor':
                $this->statisticMonitor();break;
            case 'pushMsg':
                $this->pushMsg();break;
            case 'checkToken':
                $this->checkToken();break;
            case 'sphinx':
                $this->sphinx();break;
            default:
                break;
        }
        return;
    }

    public function vcode(){
        $builder = new CaptchaBuilder;
        $builder->build();
        header('Content-type: image/jpeg');
        $builder->output();
    }


    /**
     * 统计监控系统
     */
    private function statisticMonitor(){

    }


    /**
     * 消息推送
     */
    private function pushMsg(){
        // 指明给谁推送，为空表示向所有在线用户推送
        $to_uid = "";
        // 推送的url地址，使用自己的服务器地址
        $push_api_url = "http://v218.com:2121/";
        $post_data = array(
            "type" => "publish",
            "content" => "这个是推送的测试数据",
            "to" => $to_uid,
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);
    }

    /**
     * token验证,自定义token生效时间,生效时间到期前用户没有操作则token消失
     */
    private function checkToken(){
        $TokenExt = new TokenExt();
        $token = $TokenExt->createToken('1','abc');
        //var_dump( $token );die;
        $token = 'a3hQFfCPcV04SLVF9TnT7+rBrHWcrC2O9ZfkL9vIXNPYFk80v40Nki2lsCYOdJmCOu9iU5UrYGcAzAz0vL/sQIw+yxrS/7rE/jR+F4PfV32CfSKh6Yne9mN65hadWO/3BM6HF2CGjZylSlPZG4QBb3hLqLDzu3Y9aDCG1f5FsUY=';
        $res = $TokenExt->checkToken($token);

        var_dump($res);
    }

    //sphinx搜索引擎
    private function sphinx(){

    }
}