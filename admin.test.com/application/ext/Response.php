<?php
/**
 * User: fangjinwei
 * Date: 2017/05/30 15:25
 * Desc: 提示信息
 */
namespace application\ext;

class Response {
    const FAIL          =   0;
    const SUCCESS       =   1;
    const ERROR         =   2;
    const NOTDEFINED    =   3;

    public static $message = [
        0   => '操作失败',
        1   => '操作成功',
        2   => '操作错误',
        3   => '提示信息未定义',

        //用户登陆
        10000   =>  '登陆成功',
        10001   =>  '验证码输入错误',
        10002   =>  '用户名或密码错误',
        10003   =>  '该用户己被禁用',
        10004   =>  '没有权限，非法访问',

        //菜单管理
        10100   =>  '参数错误,id为空',

        //用户管理
        10200   =>  '用户名或密码不能为空',
        10201   =>  '用户不存在',
        10202   =>  'root用户无法删除',
        10203   =>  '二次密码输入不一致，请重新输入',
        10204   =>  '原始密码输入错误',
        10205   =>  '用户权限不能大于所属组的权限',

        //用户组管理
        10300   =>  '用户组不存在',
        10301   =>  'root用户组无法删除',
    ];

    /**
     * 获取返回的数据格式
     * @param int $status 状态码 1成功,0失败 不等于1都赋值为0
     * @param int $code 此类中定义的提示信息码 默认等于$status
     * @param array $data 返回的数据
     * @param string $msg 自定义提示信息
     * @return array
     */
    public static function getResult($status=0,$code=0,$data=[],$msg='') {
        $code   = !empty($code) ? $code : $status;
        $status = !empty($status) && $status===1 ? 1 : 0;
        $return = [
            'status'	=>	$status,
            'code'		=>	$code,
            'msg'       =>  !empty($msg) ? $msg : (!empty(self::$message[$code]) ? self::$message[$code] : self::$message[self::NOTDEFINED]),
            'data'		=>	!empty($data['data']) ? $data['data'] : []
        ];
        return $return;
    }

    /**
     * json返回请求数据
     * @param int $status 状态码 1成功,0失败 不等于1都赋值为0
     * @param int $code 此类中定义的提示信息码 默认等于$status
     * @param array $data 返回的数据
     * @param string $msg 自定义提示信息
     */
    public static function response($status=0,$code=0,$data=[],$msg=''){
        $response = self::getResult($status,$code,$data,$msg);
        header("Content-type: application/json");
        exit( json_encode($response) );
    }
}