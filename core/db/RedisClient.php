<?php
/**
 * user: fangjinwei
 * date: 2017/6/16 17:43
 * desc: 获得Redis连接资源,单例多连接
 */
class RedisClient {
	private static $redis = null;
	private static $redisClient = array();

	/**
	 * RedisClient constructor.
	 * @param array $config
	 */
	private function __construct( $config = array() ){
		//设置连接超时时间，没有相关配置时默认5秒
		$timeout = array_key_exists('timeout', $config) ? $config['timeout'] : 5;

		try{
			$redis = new redis();
			$connect = $redis->connect($config['server'], $config['port'], $timeout);
		}catch( Exception $e ){
			$connect = null;
		}

		self::$redis = !empty($connect) ? $redis : null;
	}

	/**
	 * @param array $config = array(
	 * 	'server' => '127.0.0.1' 服务器
	 *  'port'   => '6379' 端口号
	 * )
	 * @return mixed
	 */
	public static function getInstance( $config = array() ){
		if ( !empty($config['server']) && !empty($config['port']) ){
			$key = $config['server'].$config['port'];

			if( empty( self::$redisClient[$key] ) ){
				new self($config);
				self::$redisClient[$key] = self::$redis;
			}

			return self::$redisClient[$key];
		}

		return null;
	}
}