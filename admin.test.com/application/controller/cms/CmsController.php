<?php
/*------------
 * 内容管理
 *-----------*/
class CmsController extends Controller{
	public function __construct(){
		parent::__construct();
		$this->module = new CmsModule();
	}
	
	//文章列表
	public function index(){
		if(!$this->post['sdate']){
			$this->post['sdate'] = date('Y-m-d',strtotime('-1 year'));
		}
		if(!$this->post['edate']){
			$this->post['edate'] = date('Y-m-d',time());
		}
		
		$where = ' 1 and addtime>=? and addtime<=? ';
		$data[] = $this->post['sdate'].' 00:00:00';
		$data[] = $this->post['edate'].' 23:59:59';

		$cates=$cid=$pid=array();
		$cateList = $this->module->getCateList();
		$cateList = $cateList ? $cateList : array();
		
		if($this->post['cid'] && $this->post['cid'][0]>0){//每个分类的id，有选择分类
			$catesTree = Common::list_to_tree($cateList);
			
			$cidCount = count($this->post['cid']);
			if($this->post['cid'][$cidCount-1] < 1){
				array_pop($this->post['cid']);
				$cidCount = $cidCount-1;
			}
			
			foreach ($this->post['cid'] as $val){
				if(isset($catesTree['_child']) && is_array($catesTree['_child'])){
					$catesTree = $catesTree['_child'][$val];
				}else{
					$catesTree = $catesTree[$val];
				}
				$cid[] = $catesTree['id'];
			}
			
			$childId = $this->getChild($catesTree);//查找子id
			$cidStr = implode (',',$childId);
			$cidStr = $this->post['cid'][$cidCount-1].','.$cidStr;
			
			$where .= " and cid in ({$cidStr}) ";
			
			$pid = $cid;
			$firstCate = $this->module->getCate($cid[0]);//获取第一级分类
			array_unshift($pid,$firstCate['pid']);//把第一级分类的pid插入数组开头位置
			$lastCid = array_pop($pid);//去掉最后一级类别的id,即$pid数组为每一级分别的父id
			
			foreach($pid as $key=>$val){//获取每一级分类内容
				foreach ($cateList as $cate){
					if($cate['pid'] == $val){
						$cates[$key][] = $cate;
					}
				}
			}
			
			$this->assign('cid',$cid);
			$this->assign('cates',$cates);
		}else{
			$cates[] = $this->module->getChildCates(0);//最大类别pid=0
			$this->assign('cates',$cates);
		}

		if($this->post['keyword']){
			$where .= " and title like ? ";
			$data[] = '%'.$this->post['keyword'].'%';
		}

		//分页显示
		$totalCount = $this->module->getCmsCount($where,$data);
		
		$pageData['options'] = array(20,50,100,200);
		$pageData['targetType'] = 'navTab';
		$pageData['totalCount'] = $totalCount;
		$pageData['numPerPage'] = $this->post['numPerPage'] ? intval($this->post['numPerPage']) : 50;
		$pageData['pageNumShown'] = 10;
		$pageData['pageNum'] = $this->post['pageNum'] ? intval($this->post['pageNum']) : 1;

		$limitStart = ($pageData['pageNum']-1)*$pageData['numPerPage'];
		$where .= " order by addtime desc limit {$limitStart},{$pageData['numPerPage']} ";
		
		foreach($cateList as $val){
			$catesByKey[$val['id']] = $val;
		}
		if($articles = $this->module->getArticleList($where,$data)){
			foreach ($articles as $key=>$val){
				$parentArr = $this->getParent($val['cid'],$catesByKey);
				krsort($parentArr['name']);
				$cateNames = implode('->',$parentArr['name']);
				$articles[$key]['cateNames'] = $cateNames;
			}
		}
		
		$this->assign('pageData',$pageData);
		$this->assign('articles',$articles);
		$this->assign('whereData',$this->post);
	}
	
	//添加内容
	public function cms_add(){
		if($this->post){
			if(is_array($this->post['cid'])){
				if($this->post['cid'][0]<1){
					$this->ajaxReturn('请选择分类');
				}
				$cidCount = count($this->post['cid']);
				if($this->post['cid'][$cidCount-1] < 1){
					array_pop($this->post['cid']);
					$cidCount = $cidCount-1;
				}
				$data['cid'] = intval($this->post['cid'][$cidCount-1]);
				$data['title'] = $this->post['title'];
				$data['intro'] = $this->post['intro'];
				$data['content'] = $this->post['content'];
				$data['imageurl'] = $this->post['imageurl'];
				$data['linkurl'] = $this->post['linkurl'];
				$data['author'] = $this->post['author'];
				$data['source'] = $this->post['source'];
				$data['keywords'] = $this->post['keywords'];
				$data['istop'] = intval($this->post['istop']);
				$data['isshow'] = intval($this->post['isshow']);
				$data['sort'] = $this->post['sort'] ? intval($this->post['sort']) : 0;
				$data['addtime'] = date('Y-m-d H:i:s');
				$data['showtime'] = $this->post['showtime'] ? $this->post['showtime'] : $data['addtime'];
			}
			
			if($this->module->addArticle($data)){
				$this->ajaxReturn('添加成功',200,$this->post['navTabId']);
			}
			
			$this->ajaxReturn('添加失败');
		}
		
		if(isset($this->get['pid']) && is_numeric($this->get['pid']) && $this->get['pid']>0){//ajax获取子分类
			$cates = $this->module->getChildCates($this->get['pid']);

			$this->ajaxReturn($cates,200);
		}
		
		$cates = $this->module->getChildCates(0);//最大类别pid=0
		
		$this->assign('cates',$cates);
	}
	
	//编辑内容
	public function cms_edit(){
		if($this->post){
			if(is_array($this->post['cid'])){
				if($this->post['cid'][0]<1){
					$this->ajaxReturn('请选择分类');
				}
				$cidCount = count($this->post['cid']);
				if($this->post['cid'][$cidCount-1] < 1){
					array_pop($this->post['cid']);
					$cidCount = $cidCount-1;
				}
				$data['cid'] = intval($this->post['cid'][$cidCount-1]);
				$data['title'] = $this->post['title'];
				$data['intro'] = $this->post['intro'];
				$data['content'] = $this->post['content'];
				$data['imageurl'] = $this->post['imageurl'];
				$data['linkurl'] = $this->post['linkurl'];
				$data['author'] = $this->post['author'];
				$data['source'] = $this->post['source'];
				$data['keywords'] = $this->post['keywords'];
				$data['istop'] = intval($this->post['istop']);
				$data['isshow'] = intval($this->post['isshow']);
				$data['sort'] = $this->post['sort'] ? intval($this->post['sort']) : 0;
				$data['addtime'] = date('Y-m-d H:i:s');
				$data['showtime'] = $this->post['showtime'] ? $this->post['showtime'] : $data['addtime'];
			}
			
			if($this->module->editArticle($this->post['id'],$data)){
				$this->ajaxReturn('编辑成功',200,$this->post['navTabId']);
			}
			
			$this->ajaxReturn('编辑失败');
		}
		
		if($this->get['id']){
			$article = $this->module->getArticle($this->get['id']);
			
			$catesAll = $this->module->getCateList();
			$catesAll = $catesAll ? $catesAll : array();
			foreach ($catesAll as $val){
				$cateList[$val['id']] = $val;
			}

			$parentArr = $this->getParent($article['cid'],$cateList);
			sort($parentArr['pid']);
			sort($parentArr['id']);
			
			foreach($parentArr['pid'] as $key=>$val){//获取每一级分类内容
				foreach ($cateList as $cate){
					if($cate['pid'] == $val){
						$cates[$key][] = $cate;
					}
				}
			}
			
			$this->assign('cid',$parentArr['id']);
			$this->assign('cates',$cates);
			$this->assign('article',$article);
		}
	}
	
	//删除内容
	public function cms_del(){
		if($this->get['id']){
			if($this->module->delArticle($this->get['id'])){
				$this->ajaxReturn('删除成功',200);
			}
		}
		if($this->post){
			if($this->module->delArticle($this->post['id'])){
				$this->ajaxReturn('删除成功',200);
			}
		}
		$this->ajaxReturn('删除失败');
	}
	
	//获取所有子分类id
	private function getChild($array,$childCate=null){
		if(isset($array['_child']) && is_array($array['_child'])){
			foreach ($array['_child'] as $key=>$val){
				if(isset($val['_child']) && is_array($val['_child'])){
					$childCate = $this->getChild($val,$childCate);
				}
				$childCate[] = $key;
			}
		}else{
			$childCate[] = $array['id'];
		}
		return $childCate;
	}
	
	//获取父类
	private function getParent($id,$menuArr,$pidArr=null){
		if($menuArr[$id]['pid'] != 0){
			$pidArr['pid'][] = $menuArr[$id]['pid'];
			$pidArr['id'][] = $id;
			$pidArr['name'][] = $menuArr[$id]['name'];
			$pidArr = $this->getParent($menuArr[$id]['pid'],$menuArr,$pidArr);
		}else{
			$pidArr['pid'][] = $menuArr[$id]['pid'];
			$pidArr['id'][] = $id;
			$pidArr['name'][] = $menuArr[$id]['name'];
		}
		return $pidArr;
	}
	
	//分类管理
	public function cate_index(){
		$cateList = $this->module->getCateList();
		$cateList = $cateList ? $cateList : array();
		
		$cateList = Common::list_to_tree($cateList);
		$cateList = Common::tree_to_list($cateList);
		
		$this->assign('cateList',$cateList);
	}
	
	//添加分类
	public function cate_add(){
		if($this->post){
			$data['pid'] = $this->post['pid'];
			$data['name'] = $this->post['name'];
			$data['sort'] = $this->post['sort'];
			$data['state'] = $this->post['state'];
			
			if($this->module->addCate($data)){
				$this->ajaxReturn('添加成功',200,$this->post['navTabId']);
			}
			
			$this->ajaxReturn('添加失败');
		}
	}
	
	//编辑分类
	public function cate_edit(){
		if($this->post){
			$data['pid'] = $this->post['pid'];
			$data['name'] = $this->post['name'];
			$data['sort'] = $this->post['sort'];
			$data['state'] = $this->post['state'];
			
			if($this->module->editCate($this->post['id'],$data)){
				$this->ajaxReturn('编辑成功',200,$this->post['navTabId']);
			}
			$this->ajaxReturn('编辑失败');	
		}else{
			if($this->get['id']){
				if($cate = $this->module->getCate($this->get['id'])){
					$this->assign('cate',$cate);
				}else{
					$this->ajaxReturn('菜单不存在');
				}
			}
		}
	}
	
	//删除分类
	public function cate_del(){
		if($this->post['id']){
			if($this->module->delCate($this->post['id'])){
				$this->ajaxReturn('删除成功',200);
			}
		}else if($this->get['id']){
			if($this->module->delCate($this->get['id'])){
				$this->ajaxReturn('删除成功',200);
			}
		}

		$this->ajaxReturn('删除失败');
	}
	
	//分类树
	public function cate_tree(){
		$cates = $this->module->getCateList();

		$cates = Common::list_to_tree($cates);
		
		$cateTree = $this->createMenuTree($cates);

		$this->assign('cateTree',$cateTree);
	}
	
	//静态生成
	public function create_html(){
		//分类/年月/文件
		//分类/年月日/文件
/*
		ob_start();
		include KG_STATIC_ROOT .'/tpl/gameTopic2/Default.html';
		$htmlCon = ob_get_contents();
		ob_end_clean();
		file_put_contents(KG_STATIC_ROOT .'/html/gameTopic2/'.$filename.'.html',$htmlCon);
*/
		//首页
		//$indexCon = file_get_content(SITE . 'html/index.html');
		
		//指定页
		//$con = file_get_content(SITE . 'html/index.html');

	}
	
	//文件列表
	public function file_index(){
		$files = $this->module->getFileList();
		
		$files = empty($files) ? array() : $files;
		
		$this->assign('files',$files);
	}
	
	//上传文件
	public function file_upload(){
		$fileName = date('YmdHis').rand(100,999).$_SESSION['uid'];
		
		if($_FILES['uploadFile']){
			if($this->post['cid'][0]<1){
				$this->ajaxReturn('请选择分类');
			}
			$upload = new Upload();
			
			$filePath = 'uploads/'.$this->post['cid'][0].'/'.date('Ym').'/';// 分类id/年月/文件名
			$upload->file_name = empty($this->post['fileName']) ? $fileName : $this->post['fileName'];
			$upload->save_path = ROOT . $filePath;
			$upload->allow_types = 'jpg|jpeg|gif|png';
			$upload->max_size = '1000000';//1000kB
			
			$pathInfo = pathinfo($_FILES['uploadFile']['name']);
			
			if(!file_exists($upload->save_path .$upload->file_name .'.'.$pathInfo['extension'])){
				if($upload->upload_file($_FILES['uploadFile'])){//文件上传
					$cidCount = count($this->post['cid']);
					if($this->post['cid'][$cidCount-1] < 1){
						array_pop($this->post['cid']);
						$cidCount = $cidCount-1;
					}
					$data['cid'] = intval($this->post['cid'][$cidCount-1]);
					$data['filepath'] = $filePath . $upload->file_name . '.' . $upload->ext;
					$data['adduser'] = $_SESSION['uname'];
					$data['addtime'] = date('Y-m-d H:i:s');
					
					if($this->module->uploadFile($data)){//文件地址入库
						$this->ajaxReturn('上传成功',200,$this->post['navTabId']);
					}else{
						$upload->errmsg = '数据库存储失败';
						$fileClass = new File();
						$fileClass->delete_file($data['filepath']);
					}
				}
			}else{
				$upload->errmsg = '文件名己存在';
			}
			
			$this->ajaxReturn($upload->errmsg);
		}
		
		
		if(isset($this->get['pid']) && is_numeric($this->get['pid']) && $this->get['pid']>0){//ajax获取子分类
			$cates = $this->module->getChildCates($this->get['pid']);

			$this->ajaxReturn($cates,200);
		}
		
		$cates = $this->module->getChildCates(0);//最大类别pid=0
		
		$this->assign('cates',$cates);
		$this->assign('fileName',$fileName);
	}
	
	//删除文件
	public function file_del(){
		$fileClass = new File();
		$msg = '';
		
		if($this->get['id']){
			if($file = $this->module->getFile($this->get['id'])){
				if($fileClass->delete_file(ROOT . $file['filepath'])){
					if($this->module->delFile($this->get['id'])){
						$this->ajaxReturn('删除成功',200,56);
					}
				}
			}
		}elseif($this->post['id']){
			
			if($files = $this->module->getFileList($this->post['id'])){
				foreach($files as $val){
					if($fileClass->delete_file(ROOT . $val['filepath'])){
						if(!$this->module->delFile($val['id'])){
							$msg .= 'id='.$val['id'].'数据库删除失败<br>';
						}
					}else{
						$msg .= 'id='.$val['id'].'文件删除失败<br>';
					}
				}
			}
		}

		if($msg){
			$this->ajaxReturn($msg);
		}else{
			$this->ajaxReturn('删除成功',200,56);
		}
	}
	
}