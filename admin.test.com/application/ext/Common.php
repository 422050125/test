<?php
/*--------------------------
 * 通用的类(常用的一些方法)
 *--------------------------*/
namespace application\ext;

class Common {
	public static function toUrl($url,$error = ''){//页面跳转
		switch ($url) {
			case 'login':
				header("Location: ./?m=sys&c=User&a=login");
				break;
			case 'index':
				header("Location: ./");
				break;
			case 'error':
				header("Location: ./?m=sys&c=Sys&a=error&msg=".urldecode($error));
				break;
			default:
				header("Location: ".$url);
				break;
		}
	}

	public static function alert($msg){
		echo '<script type="text/javascript" src="/static/lib/H-ui.admin_v3.0/lib/jquery/1.9.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="/static/lib/H-ui.admin_v3.0/lib/layer/layer.js"></script>';
		echo "<script>layer.alert( '$msg',{icon: 2},function(){var frameindex= parent.layer.getFrameIndex(window.name);parent.layer.close(frameindex);} )</script>";
		die;
	}

	//判断是否ajax请求
	public static function isAjax() {
		//jquery设定ajax请求的$_SERVER['HTTP_X_REQUESTED_WITH'] = XMLHttpRequest
		if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
			return true;
		return false;
	}
	
	//把返回的数据集转换成Tree
	public static function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0){
		// 创建Tree
		$tree = array();
		if(is_array($list)) {
			// 创建基于主键的数组引用
			$refer = array();
			foreach($list as $key => $data){
				$refer[$data[$pk]] =& $list[$key];
			}
			foreach($list as $key => $data){
				// 判断是否存在parent
				$parentId = $data[$pid];
				if($root == $parentId) {
					$tree[$data[$pk]] =& $list[$key];//将数组的id作为tree的key
				}else{
					if(isset($refer[$parentId])){
						$parent =& $refer[$parentId];
						$parent[$child][$data[$pk]] =& $list[$key];//将数组的id作为tree的key
					}
				}
			}
		}
		return $tree;
	}

	//将Tree转换成List，以便模板赋值输出
	public static function tree_to_list($tree,$depth=0,$left=20){
		static $myarray=array();
		static $depth;
		foreach($tree as $v){
			$space = $left*$depth .'px';
			//$space='margin-left:'.$left*$depth.'px';//下级缩进
			$depth % 2==0?$color='color:green':$color='';//下级和上级分开颜色
			$temp=$v;
			unset($temp['_child']);
			$temp['_space']=$space;
			$temp['_color']=$color;
			$myarray[]=$temp;
			empty($v['_child']) ? '' : self::tree_to_list($v['_child'],++$depth);
		}
		$depth!=0?--$depth:'';
		return $myarray;
	}
	
	//下载excel $data格式为serialize($data);
	public static function downExcel($filename='excel.xls',$data){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		
		if($arr=unserialize($data)){
			foreach($arr as $val){
				foreach($val as $v){
					echo $v.chr(9);
				}
				echo chr(13);
			}
		}
	}
	
	/**
	* 二分法取数
	* $arr 数组
	* $min 最小值的索引
	* $max 最大值的索引
	* $num 需要查找的数
	*/
	public static function getNum($arr,$min,$max,$num){
		if($num==$arr[$min] || $num==$arr[$max]){
			return $num;
		}
		
		$k = floor(($max+$min)/2);
		
		if($num>$arr[$k]){
			$returnNum = self::getNum($arr,$k,$max,$num);
		}
		elseif($num<$arr[$k]){
			$returnNum = self::getNum($arr,$min,$k,$num);
		}
		else{
			$returnNum = $num;
		}

		return $returnNum;
	}

	/**
	* 得到用户IP
	* 
	*/
	public static function getUserIP(){
		$realIP = FALSE;
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$realIP = $_SERVER['HTTP_CLIENT_IP'];
		}
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ips = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach($ips as $ip)
			{
				$ip = trim($ip);
				//if(!self::isLAN($ip)) //非局域网
				//{
					$realIP = $ip;
					break;
				//}
			}
		}
		return ($realIP ? $realIP : $_SERVER['REMOTE_ADDR']);
	}
	
	/*
	*验证是否邮箱地址
	*/
	public static function checkIsEmail($mail){
		return preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',$mail);
	}
	
	//php获取中文字符拼音首字母
	public static function getFirstCharter($str){
		if(empty($str)){
			return '';
		}
		//首字符
		$fchar=ord($str{0});
	
		if($fchar>=ord('A')&&$fchar<=ord('z')) {
			return strtoupper($str{0});
		}

		$s1 = iconv("UTF-8","GBK", $str);

		$s2 = iconv("GBK","UTF-8", $s1);
		
		$s=$s2==$str?$s1:$str;
		
		$asc=ord($s{0})*256+ord($s{1})-65536;
	
		if($asc>=-20319&&$asc<=-20284) return 'A';
		if($asc>=-20283&&$asc<=-19776) return 'B';
		if($asc>=-19775&&$asc<=-19219) return 'C';
		if($asc>=-19218&&$asc<=-18711) return 'D';
		if($asc>=-18710&&$asc<=-18527) return 'E';
		if($asc>=-18526&&$asc<=-18240) return 'F';
		if($asc>=-18239&&$asc<=-17923) return 'G';
		if($asc>=-17922&&$asc<=-17418) return 'H';
		if($asc>=-17417&&$asc<=-16475) return 'J';
		if($asc>=-16474&&$asc<=-16213) return 'K';
		if($asc>=-16212&&$asc<=-15641) return 'L';
		if($asc>=-15640&&$asc<=-15166) return 'M';
		if($asc>=-15165&&$asc<=-14923) return 'N';
		if($asc>=-14922&&$asc<=-14915) return 'O';
		if($asc>=-14914&&$asc<=-14631) return 'P';
		if($asc>=-14630&&$asc<=-14150) return 'Q';
		if($asc>=-14149&&$asc<=-14091) return 'R';
		if($asc>=-14090&&$asc<=-13319) return 'S';
		if($asc>=-13318&&$asc<=-12839) return 'T';
		if($asc>=-12838&&$asc<=-12557) return 'W';
		if($asc>=-12556&&$asc<=-11848) return 'X';
		if($asc>=-11847&&$asc<=-11056) return 'Y';
		if($asc>=-11055&&$asc<=-10247) return 'Z';
		return substr($str,0,1);
	}
}