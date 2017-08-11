<?php
/**
 * User: fangjinwei
 * Date: 2017/06/17 1:22
 * Desc: redis操作类
 */
class RedisCacheExt {
    public $redis;

    public function __construct( $config=array() )
    {
        if( empty($config) || empty($config['server']) || empty($config['port']) ){
            global $redisConfig;
            $config = $redisConfig['default'];
        }
        $this->redis = RedisClient::getInstance( $config );
    }

    /**
     * 设置值
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public function set($key, $value, $timeOut = 3600) {
        if (empty($this->redis)){
            return false;
        }
        $value = json_encode($value);
        $retRes = $this->redis->set($key, $value);
        if ($timeOut > 0) $this->redis->setTimeout($key, $timeOut);
        return $retRes;
    }

    /**
     * 通过KEY获取数据
     * @param string $key KEY名称
     */
    public function get($key) {
        if (empty($this->redis)){
            return false;
        }
        $result = $this->redis->get($key);
        return json_decode($result, TRUE);
    }
    /**
     * setex 带生存时间的写入值
     *  $redis->setex('key', 3600, 'value'); // sets key → value, with 1h TTL.
     *
     * @access public
     * @param mixed $key
     * @return void
     */
    public function setex($key, $value, $timeOut = 3600){
        if (empty($this->redis)){
            return false;
        }
        $value = json_encode($value);
        $retRes = $this->redis->setex($key, $timeOut, $value);
    }
    /**
     * 删除一条数据
     * @param string $key KEY名称
     */
    public function delete($key) {
        if (empty($this->redis)){
            return false;
        }
        return $this->redis->delete($key);
    }

    /**
     * 清空数据
     */
    public function flushAll() {
        if (empty($this->redis)){
            return false;
        }
        return $this->redis->flushAll();
    }

    /**
     * 数据入队列
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param bool $right 是否从右边开始入
     */
    public function push($key, $value ,$right = true) {
        if (empty($this->redis)){
            return false;
        }
        $value = json_encode($value);
        return $right ? $this->redis->rPush($key, $value) : $this->redis->lPush($key, $value);
    }

    /**
     * 数据出队列
     * @param string $key KEY名称
     * @param bool $left 是否从左边开始出数据
     */
    public function pop($key , $left = true) {
        if (empty($this->redis)){
            return false;
        }
        $val = $left ? $this->redis->lPop($key) : $this->redis->rPop($key);
        return json_decode($val, TRUE);
    }

    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment($key) {
        if (empty($this->redis)){
            return false;
        }
        return $this->redis->incr($key);
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement($key) {
        if (empty($this->redis)){
            return false;
        }
        return $this->redis->decr($key);
    }

    /**
     * key是否存在，存在返回ture
     * @param string $key KEY名称
     */
    public function exists($key) {
        if (empty($this->redis)){
            return false;
        }
        return $this->redis->exists($key);
    }

    /**
     * 返回redis对象
     * redis有非常多的操作方法，我们只封装了一部分
     * 拿着这个对象就可以直接调用redis自身方法
     */
    public function getRedis() {
        return $this->redis;
    }

    public function hget($listname, $key) {
        if (empty($this->redis)){
            return false;
        }
        return $this->redis->hget($listname, $key);
    }

    public function hset($key,$hashkey,$value,$timeout=300) {
        if(!empty($this->redis)){
            $value	=	json_encode($value);
            if(!$this->redis->exists($key)){
                if($this->redis->hset($key,$hashkey,$value)){
                    return $this->redis->expire($key,$timeout);
                };
            }else{
                return $this->redis->hset($key,$hashkey,$value);
            }
        }
        return false;
    }

    public function hexists($key,$hashkey){
        if(!empty($this->redis)){
            return $this->redis->hexists($key,$hashkey);
        }
        return false;
    }
}