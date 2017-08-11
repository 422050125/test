<?php
/**
 * Memcached缓存类--单服务器
 * @package  cache
 * @author    
 * @example
		 $options = array
			(
			'host' => '127.0.0.1', //memcached服务端监听主机地址
			'port' => 11211,      //memcached服务端监听端口
			'weight' => 3,          //缓存权重
		);
		$mem = new MemcachedClient($options);
		$mem->set('key', time(), 10);
		echo $mem->get('key');
 */

class MemcachedClient 
{
	/**
	 * 构造函数
	 * @access public
	 * @param array $options 配置参数
	 */
	public $expire = 60;
	public $handler;
	public $connected;
	
	/**
	 * 构造函数 暂未实现单例，在kgHelper中实现
	 * 
	 * @access public
	 * @param string $options
	 * @return void
	 */
	public function __construct($options='') {
	
		if (!extension_loaded('memcached')) {
			///die('Error: NOT SUPPORT memcached!');
		}
		if (empty($options)) {
			$options = array
				(
					'host' => '183.60.41.72',
					'port' => 11212,
					'weight' => 3,
			);
		}

		if (isset($this->handler) and is_resource($this->handler)) return $this->handler;
		
		$this->handler = new Memcached();
		$this->connected = $this->handler->addServer($options['host'], $options['port'], $options['weight']);
		return $this->handler;
	}

	/**
	 * 读取缓存
	 * @access public
	 * @param string $key 缓存变量名
	 * @return mixed
	 */
	public function get($key) {
		return $this->handler->get($key);
	}

	/**
	 * 写入缓存
	 * @access public
	 * @param string $key 缓存变量名
	 * @param mixed $value  存储数据
	 * @param int $ttl 以秒为单位的失效时间， 如果设置为0表明该元素永不过期
	 * @return boolen
	 */
	public function set($key, $value, $ttl = null) {
		if (isset($ttl) && is_int($ttl))
			$expire = $ttl;
		else
			$expire = $this->expire;
		$value = json_encode($value);
		return $this->handler->set($key, $value, $expire);
	}

	/**
	 * 删除缓存
	 * @access public
	 * @param string $key 缓存变量名
	 * @param int $timeout 如果值为0,则该元素立即删除，如果值为30,元素会在30秒内被删除。
	 * @return boolen
	 */
	public function rm($key, $timeout = false) {
		return $timeout === false ?
				$this->handler->delete($key) :
				$this->handler->delete($key, $timeout);
	}

	/**
	 * 清除缓存
	 * @access public
	 * @return boolen
	 */
	public function clear() {
		return $this->handler->flush();
	}
	
	/**
	 * 是否连接
	 * @access private
	 * @return boolen
	 */
	private function isConnected() {
		return $this->connected;
	}   
	
	/**
	 * 获得资源句柄，外部可调用
	 * 
	 * @access public
	 * @return resource
	 */
	public function getMemcached() {
		return $this->handler;
	} 
}
