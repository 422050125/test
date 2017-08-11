<?php
class CmsModule extends Module{
	
	public function __construct(){
		parent::__construct('default');
	}
	
	//获取文章
	public function getArticle($id){
		return $this->table('cms_articles')->field('*')->where('id=?')->fetch(array($id));
	}
	
	//获取文章列表
	public function getArticleList($where='1',$data=null){
		return $this->table('cms_articles')->field('*')->where($where)->fetchAll($data);
	}
	
	//获取文章总数
	public function getCmsCount($where,$data){
		return $this->table('cms_articles')->field('*')->where($where)->fetchTotal($data);
	}
	
	//添加文章
	public function addArticle($data){
		return $this->table('cms_articles')->insert($data);
	}
	
	//修改文章
	public function editArticle($id,$data){
		$where['id'] = $id;
		return $this->table('cms_articles')->where($where)->update($data);
	}
	
	//删除文章
	public function delArticle($id){
		$where['id'] = $id;
		return $this->table('cms_articles')->where($where)->delete();
	}
	
	//获取子分类
	public function getChildCates($pid){
		return $this->table('cms_cates')->field('*')->where('pid=?')->fetchAll(array($pid));
	}
	
	//获取所有分类
	public function getCateList(){
		return $this->table('cms_cates')->field('*')->where()->fetchAll();
	}
	
	//获取一条分类
	public function getCate($id){
		$data[] = $id;
		return $this->table('cms_cates')->field('*')->where('id=?')->fetch($data);
	}
	
	//添加分类
	public function addCate($data){
		return $this->table('cms_cates')->insert($data);
	}
	
	//修改分类
	public function editCate($id,$data){
		$where['id'] = $id;
		return $this->table('cms_cates')->where($where)->update($data);
	}
	
	//删除分类
	public function delCate($id){
		$where['id'] = $id;
		return $this->table('cms_cates')->where($where)->delete();
	}
	
	//上传文件地址入库
	public function uploadFile($data){
		return $this->table('cms_files')->insert($data);
	}
	
	//获取上传的文件地址
	public function getFileList($where=1,$data=null){
		$idStr = '';
		if(is_array($where) && !empty($where)){
			foreach ($where as $val){
				$idStr .= '?,';
				$data[] = $val;
			}
			$where = ' id in('. rtrim($idStr,',') .') ';
		}else{
			$where = '1 order by addtime desc ';
		}
		return $this->table('cms_files')->field('*')->where($where)->fetchAll($data);
	}
	
	//获取一条文件地址
	public function getFile($id){
		return $this->table('cms_files')->field('*')->where('id=?')->fetch(array($id));
	}
	
	//删除上传的文件地址
	public function delFile($id){
		$where['id'] = $id;
		return $this->table('cms_files')->where($where)->delete();
	}
}

