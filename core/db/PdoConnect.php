<?php
/*--------------------
 * 数据据操作类(pdo)
 *--------------------*/
namespace db;

class PdoConnect {
	private $conn = null;
	private static $instance;

	protected function __construct($dbLink) {
		if( $this->conn === null ){
			$this->conn = $this->connect($dbLink);
		}
	}

	protected static function getInstance($dbname='default'){
		if( empty(self::$instance[$dbname]) ){
			self::$instance[$dbname] = new self($GLOBALS['dbConfig'][$dbname]);
		}
		return self::$instance;
	}
	
	//连接数据库
	private function connect($dbLink) {
		try {
			$this->conn = new \PDO ($dbLink['DB_TYPE'].':host='.$dbLink['DB_HOST'].'; port='.$dbLink['DB_PORT'].'; dbname='.$dbLink['DB_NAME'], $dbLink['DB_USER'],$dbLink['DB_PASSWD']);
		} catch ( \Exception $e ) {
			exit ('connect db error');
		}

		$this->conn->exec('SET NAMES '.$dbLink['DB_CHARSET']);
		
		return $this->conn;
	}
	
	/**
	 * 查询一条数据
	 * @param string $sql		sql语句
	 * @param array $bindVal	绑定条件的值
	 * @return array 			返回一维数组
	 */
	protected function _fetch($sql, $bindVal=null, $style=\PDO::FETCH_ASSOC) {

		$pd = $this->conn->prepare($sql);
		
		if($pd->execute($bindVal)){
			return $pd->fetch(\PDO::FETCH_ASSOC);
		}
		
		return false;
	}
	
	/**
	 * 查询多条数据
	 * @param string $sql		sql语句
	 * @param array $bindVal	绑定条件的值
	 * @return array 			返回二维数组
	 */
	protected function _fetchAll($sql, $bindVal=null, $style=\PDO::FETCH_ASSOC) {

		$pd = $this->conn->prepare($sql);
		
		if($pd->execute($bindVal)){
			return $pd->fetchAll($style);
		}
		
		return false;
	}
	
	/**
	 * 查询总记录数
	 * @param string $sql		sql语句
	 * @param array $bindVal	绑定条件的值
	 * @return int				返回总记录数
	 */
	protected function _fetchTotal($sql, $bindVal=null, $style=\PDO::FETCH_NUM) {

		$pd = $this->conn->prepare($sql);

		if($pd->execute($bindVal)){
			$countRows = $pd->fetch(\PDO::FETCH_NUM);
			return $countRows[0];
		}
		
		return false;
	}
	
	/**
	 * 插入数据
	 * @param string $sql		sql语句
	 * @param array $bindVal 	绑定条件的值
	 * @return int 				返回插入的id值
	 */
	protected function _insert($sql, $bindVal=null) {

		$pd = $this->conn->prepare($sql);
		
		if($pd->execute($bindVal)){
			return $this->conn->lastInsertId();
		}
		
		return false;
	}
	
	/**
	 * 修改数据
	 * @param string $sql			sql语句
	 * @param array $bindVal		绑定条件的值
	 * @return bool
	 */
	protected function _update($sql,$bindVal=null) {

		$pd = $this->conn->prepare($sql);
		
		if($pd->execute($bindVal)){
			return $pd->rowCount();
		}
		
		return false;
	}
	
	/**
	 * 删除数据
	 * @param string $sql			sql语句
	 * @param array bindVal			绑定条件的值
	 * @return bool
	 */
	protected function _delete($sql, $bindVal=null) {

		$pd = $this->conn->prepare($sql);
		
		if($pd->execute($bindVal)){
			return $pd->rowCount();
		}
		
		return false;
	}
	
	//查看执行的sql语句
	protected function querySql($sql,$bindVal=null) {
		if($bindVal){
			$countVal = count($bindVal);
			for ($i=0; $i<=$countVal; $i++){
				$sql = preg_replace('/(\?)/',"'".$bindVal[$i]."'",$sql,1);
			}
		}else{
			return $sql;
		}
		
		return $sql;
	}
	
	public function __destruct() {
		$this->conn = null;
	}
}
?>