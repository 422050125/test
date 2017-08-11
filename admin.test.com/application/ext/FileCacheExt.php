<?php
/**
 * user: fangjinwei
 * date: 2017/6/5 20:08
 * desc: 文件操作
 */
class FileCache {
    public static $cacheTime = 3600;

    //生成缓存,filename文件名,data数据,type是否需要使用反斜线引用字符串
    public function makeCache($filename, $data, $type=false){
        if(!file_exists(CACHE_DATA_DIR)){
            mkdir(CACHE_DATA_DIR,777);
        }

        $filename = CACHE_DATA_DIR . $filename . '.php';
        $content='<?php if(CACHE_DATA!=\'yes\'){die("Forbidden Access");} ';

        if(self::$cacheTime>0){
            $content .= '$cache_time='.(time()+self::$cacheTime).'; ';
        }
        if(is_array($data)){
            $content .= '$cache_type=\'array\'; ';
            $data = serialize($data);
        }

        if($type){//使用反斜线引用字符串
            $data = addslashes($data);
        }

        $content .= '$cache_data=\''.$data.'\'; ';
        $content .= '?>';

        if(!$fp = fopen($filename, "wa")){
            return 'open fail';
        }
        if(!fwrite($fp, $content)){
            fclose($fp);
            return 'write fail';
        }
        fclose($fp);
        return true;
    }

    //获取缓存,filename文件名,type是否需要反引用一个使用 addcslashes() 转义的字符串
    public function getCache($filename,$type=false){
        $cache_data = $cache_type = '';
        $filename = CACHE_DATA_DIR . $filename .'.php';
        define("CACHE_DATA",'yes');
        if(!file_exists($filename)){
            return false;
        }
        include($filename);
        if(isset($cache_time) && $cache_time>0 && $cache_time<time()){
            return false;
        }
        if(!$cache_data){
            return false;
        }
        if($cache_type == 'array'){
            $cache_data = unserialize($cache_data);
        }

        if($type){//反引用
            return stripcslashes($cache_data);
        }
        return $cache_data;
    }

    //清除缓存
    public function clearCacheFile(){
        if($this->post){
            if(!is_array($this->post['type']) || empty($this->post['type'])){
                $this->ajaxReturn('请选择清空类型');
            }

            $file = new File();

            foreach ($this->post['type'] as $val){
                switch ($val){
                    case 1:
                        $file->delete_dir(CACHE_DATA_DIR);//删除数据缓存目录
                        break;
                    case 2:
                        $file->delete_dir(CACHE_TEMP_DIR);//删除模板缓存目录
                        break;
                    case 3:
                        $file->delete_dir(COMPILES_DIR);//删除编译目录
                        break;
                    default:
                        break;
                }
            }

            $this->ajaxReturn('清除成功',200);
        }
    }
}