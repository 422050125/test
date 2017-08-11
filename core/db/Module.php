<?php
/**
 * User: fangjinwei
 * Date: 2017/06/03 16:56
 * Desc: module基类
 */
namespace db;

class Module extends PdoConnect {
	protected $table = null;
	protected $prefix = null;
	private $field = null;
	private $where = null;
	private $sql = false;

	protected function __construct($dbname='default'){
		parent::__construct($GLOBALS['dbConfig'][$dbname]);
		$this->table = $this->prefix . $this->table;
	}

	/**
	 * 查询一条数据
	 * @param array/string $sql		$sql为array时为绑定参数的值，为string时则为sql语句
	 * @param array $data			绑定条件的值
	 * @return array 				返回一维数组
	 */
	protected function fetch($sql=null,$data=null){
		if(is_array($sql) || $sql===null){
			$data = $sql;
			$sql = "select {$this->field} from {$this->table} where {$this->where}";
		}
		if($this->sql){
			exit ($this->querySql($sql,$data));
		}
		
		return $this->_fetch($sql,$data);
	}

	/**
	 * 查询多条数据
	 * @param array/string $sql		$sql为array时为绑定参数的值，为string时则为sql语句
	 * @param array $data			绑定条件的值
	 * @return array 				返回一维数组
	 */
	protected function fetchAll($sql=null,$data=null){
		if(is_array($sql) || $sql===null){
			$data = $sql;
			$sql = "select {$this->field} from {$this->table} where {$this->where}";
		}
		if($this->sql){
			exit ($this->querySql($sql,$data));
		}
		
		return $this->_fetchAll($sql,$data);
	}
	
	/**
	 * 查询总记录数
	 * @param array/string $sql		$sql为array时为绑定参数的值，为string时则为sql语句
	 * @param array $data			绑定条件的值
	 * @return int 					总记录数
	 */
	protected function fetchTotal($sql=null,$data=null){
		if(is_array($sql) || $sql===null){
			$data = $sql;
			$sql = "select count({$this->field}) from {$this->table} where {$this->where}";
		}
		if($this->sql){
			exit ($this->querySql($sql,$data));
		}
		
		return $this->_fetchTotal($sql,$data);
	}

	/**
	 * 插入数据
	 * @param array/string $sql		$sql为array时为绑定参数的值，为string时则为sql语句
	 * @param array $data 			绑定条件的值
	 * @return int 					返回插入的id值
	 */
	protected function insert($sql=null,$data=null){
		if(is_array($sql)){
			if(empty($sql)) return false;
			$res = $this->insertSqlCondition($sql);
			$sql = $res['sql'];
			$data = $res['data'];
		}
		if($this->sql){
			exit ($this->querySql($sql,$data));
		}
		
		return $this->_insert($sql,$data);
	}

	/**
	 * 修改数据
	 * @param array/string $sql		$sql为array时为绑定参数的值，为string时则为sql语句
	 * @param array $data			绑定条件的值
	 * @return bool
	 */
	protected function update($sql=null,$data=null){
		if(is_array($sql) || $sql===null){
			$res = $this->updateSqlCondition($sql);
			$sql = $res['sql'];
			$data = $res['data'];
		}
		if($this->sql){
			exit ($this->querySql($sql,$data));
		}
		
		return $this->_update($sql,$data);
	}

	/**
	 * 删除数据
	 * @param string $sql		$sql为string时则为sql语句
	 * @param array $data		绑定条件的值
	 * @return bool
	 */
	protected function delete($sql=null,$data=null){
		if($sql===null){
			$res = $this->deleteSqlCondition();
			$sql = $res['sql'];
			$data = $res['data'];
		}
		if($this->sql){
			exit ($this->querySql($sql,$data));
		}
		
		return $this->_delete($sql,$data);
	}
	
	//表名称
	protected function table($table){
		$this->table = $table;
		return $this;
	}
	
	//字段名
	protected function field($field='*'){
		$this->field = $field;
		return $this;
	}
	
	//where条件
	protected function where($where=1){
		$this->where = $where;
		return $this;
	}
	
	//是否查看执行的sql语句
	protected function sql(){
		$this->sql = true;
		return $this;
	}
	
	/**
	 * 组合插入语句
	 * @param array $data 		key=>字段，value=>值
	 * @return array			返回二维数组，sql=>组合后的sql语句,  data=>绑定的值
	 */
	private function insertSqlCondition($data){
		$keys = $vals = '';
		$returnData = $bindVal = array();
		
		foreach ($data as $k=>$v){
			$keys .= "`{$k}`,";
			$vals .= "?,";
			$bindVal[] = $v;
		}
		
		$keys = rtrim ($keys, ',');
		$vals = rtrim ($vals, ',');
		
		$returnData['sql'] =  "insert into {$this->table} ({$keys}) values ({$vals})";
		$returnData['data'] = $bindVal;
		
		return $returnData;
	}
	
	/**
	 * 组合修改语句 (where为数组时组合=条件,key=>value)
	 * @param array $data 		key=>字段，value=>值
	 * @return array			返回二维数组，sql=>组合后的sql语句,  data=>绑定的值
	 */
	private function updateSqlCondition($data){
		$str = '';
		$returnData = $bindVal = array();
		
		foreach ($data as $key=>$val){
			$str .= "`{$key}`=?,";
			$bindVal[] = is_array($val) ? (!empty($val) ? implode(',',$val) : '') : $val;
		}

		$str = rtrim($str,',');
		$returnData['data'] = $bindVal;
		
		if(is_array($this->where) && !empty($this->where)){
			foreach ($this->where as $key=>$val){
				$returnData['sql'] = "update {$this->table} set {$str} where `{$key}`=?";
				$returnData['data'][] = $val;
			}
		}else{
			$returnData['sql'] = "update {$this->table} set {$str} where {$this->where}";
		}
		
		return $returnData;
	}
	
	/**
	 * 组合删除语句 (where为数组时组合in或=条件,key=>value)
	 * @return array			返回二维数组，sql=>组合后的sql语句,  data=>绑定的值
	 */
	private function deleteSqlCondition(){
		$str = '';
		$returnData = $bindVal = array();
		
		if(is_array($this->where) && !empty($this->where)){
			foreach ($this->where as $key=>$val){
				if(is_array($val)){
					foreach ($val as $v){
						$str .= "?,";
						$bindVal[] = $v;
					}
					$str = ' in ('. rtrim($str,',') .')';
				}else{
					$str = "=?";
					$bindVal[] = $val;
				}
				$returnData['sql'] =  "delete from {$this->table} where {$key} {$str}";
			}
		}else{
			$returnData['sql'] =  "delete from {$this->table} where {$this->where} ";
		}
		
		$returnData['data'] = $bindVal;
		
		return $returnData;
	}
	
}