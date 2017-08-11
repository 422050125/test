<?php
/**
 * user: fangjinwei
 * date: 2017/6/16 17:43
 * desc: token操作
 */
class TokenExt {
    private $cacheTime = 5;
    private $redis;
    private $EncryptExt;

    public function __construct()
    {
        $this->redis = new RedisCacheExt( ['server'=>'192.168.2.193','port'=>'6379'] );
        $this->EncryptExt = new EncryptExt();
    }

    /**
     * 生成Token
     */
    public function createToken($uid,$name,$ext=null){
        if( empty($uid) || empty($name) ){
            return false;
        }

        $data = ['uid'=>$uid,'uname'=>$name,'time'=>time(),'ext'=>$ext];

        $jsonData = json_encode( $data );

        $token = $this->EncryptExt->RsaPublicEncrypt( $jsonData );

        $key = md5($token);

        $this->redis->set( $key, $token, $this->cacheTime );

        return $token;
    }

    /**
     * token验证
     * @param $token
     * @return bool
     */
    public function checkToken($token){
        $key = md5($token);

        if( empty($cacheToken = $this->redis->get($key)) ){
            return false;
        }
        if( empty( $jsonData = $this->EncryptExt->RsaPrivateDecrypt( $cacheToken ) ) ){
            return false;
        }
        if( empty($tokenArr = json_decode( $jsonData,true )) ){
            return false;
        }
        if( empty($tokenArr['uid']) || empty($tokenArr['uname']) ){
            return false;
        }

        $this->redis->set( $key, $token, $this->cacheTime );

        $tokenArr['token'] = $token;

        return $tokenArr;
    }

}