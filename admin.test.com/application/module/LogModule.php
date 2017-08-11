<?php
/**
 * User: fangjinwei
 * Date: 2017/06/03 16:56
 * Desc: 操作日志模型
 */
namespace application\module;
use db\module;

class LogModule extends Module {
    protected $table = 'sys_log';

    public function __construct()
    {
        parent::__construct();
    }

    //添加日志
    public function addLog($data){
        return $this->table('sys_log')->insert($data);
    }

    //查询日志
    public function getLog($where,$order,$limit){
        $sql = "select * from sys_log where {$where} order by addtime {$order} limit {$limit}";

        return $this->fetchAll($sql);
    }

    //查询日志总数
    public function getLogCount($where){
        $sql = "select count(*) from sys_log where {$where}";

        return $this->fetchTotal($sql);
    }
}