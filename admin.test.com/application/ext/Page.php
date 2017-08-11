<?php
/**
 * User: fangjinwei
 * Date: 2017/06/11 15:16
 * Desc:
 */
namespace application\ext;

class Page{
    //显示当前页的前后页数  4,5,6,七,8,9,10
    const OFFSET=3;
    //每页总数
    const PAGE_SIZE = 20;
    //$get表示get参数数组
    public static function showPager(&$page_no,$page_size,$row_count){
        $urlArr = explode('?',$_SERVER['REQUEST_URI']);
        $url = str_replace('//','/',$urlArr[0]);
        $params = preg_replace('/&page_no=\w+/i','',$urlArr[1]);
        $navibar = '<div style="clear: both;color: #666;float: left;font-size: 14px;padding-top: 10px;">共 <span class="show-num">'. $row_count.'</span> 条</div>';
        $navibar .= '<form method="GET" action="'.$url.'?'.$params.'">';

        if(!empty($get)) {
            foreach ($get as $k=>$v) {
                $navibar .='<input type=hidden value="'.$v.'" name="'.$k.'"/>';
            }
        }

        $offset=self::OFFSET;

        $navibar .='<div style="float: right;padding-top: 10px;text-align: right;">';
        $page_size = intval($page_size);
        $page_size= $page_size > 0?$page_size:10;

        $total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);

        $page_no=($page_no<1||!is_numeric($page_no))?1:$page_no;
        if($page_no>$total_page && $page_no>1)
        {
            $page_no = $total_page;
            header('Location:'.$url.'?'.$params.'&page_no='.$page_no);
            exit;
        }

        if ($page_no > 1){
            $navibar .= '<a style="border: 1px solid #ccc;color: #666;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;" href="'.$url.'?'.$params.'&page_no=1">首页</a>';
            $navibar .= '<a style="border: 1px solid #ccc;color: #666;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;" href="'.$url.'?'.$params.'&page_no='.($page_no-1).'">上一页</a>';
        }
        /**** 显示页数 分页栏显示11页，前5条...当前页...后5条 *****/
        $start_page = $page_no -$offset;
        $end_page =$page_no+$offset;
        if($start_page<1){
            $start_page=1;
        }
        if($end_page>$total_page){
            $end_page=$total_page;
        }
        for($i=$start_page;$i<=$end_page;$i++){
            if($i==$page_no){
                $navibar .= '<span><a style="background: #5a98de none repeat scroll 0 0;border: 1px solid #ccc;color: #fff;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;">'.$i.'</a></span>';
            }else{
                $navibar .= '<a style="border: 1px solid #ccc;color: #666;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;" href="'.$url.'?'.$params.'&page_no='.$i.'">'.$i.'</a>';
            }
        }

        if ($page_no < $total_page){
            $navibar .= '<a style="border: 1px solid #ccc;color: #666;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;" href="'.$url.'?'.$params.'&page_no='.($page_no+1).'">下一页</a>';
            $navibar .= '<a style="border: 1px solid #ccc;color: #666;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;" href="'.$url.'?'.$params.'&page_no='.$total_page.'">末页</a>';
        }
        if($total_page>0){
            $navibar .= '<input type="text" name="page_no" style="width:20px;color: #666;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 3px 6px;padding: 0 10px;text-align: center;text-decoration: none;" value='.$page_no.'>';
            $navibar .= '<a style="border: 1px solid #ccc;color: #666;cursor: pointer;display: inline-block;font-size: 14px;height: 26px;line-height: 26px;margin: 0 0 6px 6px;padding: 0 10px;text-align: center;text-decoration: none;">'.$page_no ."/". $total_page.'</a>';
        }
        $navibar .= '</form>';
        $navibar.="</div>";

        return $navibar;
    }


    /*
     * 通用分页
     * 支持ajax分页,
     * 默认取当前url参数,
     * $pageoptions
      'AutoHide' => int 0 当总页数只有一页时是否自动隐藏
      'PageIndexParameterName' => string 'page_id' (length=7) url中页索引参数的名称
      'NumericPagerItemCount' => int 10 显示的最大数字页索引按钮数(+1)
      'PrevPageText' => string '上一页' (length=9) 上一页文本
      'NextPageText' => string '下一页' (length=9) 下一页文本
      'ShowFirstLast' => int 0 是否显示第一页和最后一页
      'ShowPrevNext' => int 1 是否显示上一页和下一页
      'ShowNumericPagerItems' => int 0 是否显示数字分页索引
      'ShowPageIndexBox' => int 0 是否显示跳转及输入框
      'ShowMorePagerItems' => int 0 是否显示更多页
      'GoButtonText' => string ' 跳转 ' (length=8) 跳转文本
      'MorePageText' => string '...' (length=3) 更多页文本
      'CssClass' => string 'page2' (length=5) CSS样式类
      'TagName' => string 'div' (length=3) 容器标签名，默认为div
      'IsAjax' => int 1 是否ajax分页
      'TargetId' => string 'uyes_data_list' (length=9) IsAjax=1时有效,请求完成后被更新内容的容器Id
      'OnBegin' => string 'ajax_send();' (length=12) IsAjax=1时有效,请求时执行的函数名
      'OnComplete' => string 'ajax_complete();' (length=16) IsAjax=1时有效,完成时执行的函数名
      'OnError' => string 'ajax_error();' (length=16) //todo...
     *
     */
    public static function pager($page_no, $page_size, $row_count, $pageoptions = null, $show_row_count = 0)
    {
        if($row_count<=0){
            return;
        }

        $totalpage = $row_count % $page_size == 0 ? $row_count / $page_size : ceil($row_count / $page_size);

        $html = "";

        $onbegin = 'App.blockUI(jQuery("#uyes_data_list").parents(".portlet"));';
        $oncomplete = 'App.unblockUI(jQuery("#uyes_data_list").parents(".portlet"));';
        if (!isset($pageoptions)) {
            $pageoptions = array("AutoHide" => 0, "PageIndexParameterName" => "page_no", "NumericPagerItemCount" => 10, "PrevPageText" => "&lsaquo;", "NextPageText" => "&rsaquo;", "FirstPageText" => "&laquo;", "LastPageText" => "&raquo;",
                "ShowFirstLast" => 1, "ShowPrevNext" => 1, "ShowNumericPagerItems" => 1, "ShowPageIndexBox" => 1, "ShowMorePagerItems" => 0, "GoButtonText" => " 跳转 ", "MorePageText" => "...", "CssClass" => "cmm-pager", "TagName" => "div", "IsAjax" => 1, "TargetId" => "uyes_data_list", "OnBegin" => $onbegin, "OnComplete" => $oncomplete);
        }

        if ($totalpage <= 1) {
            $html = '<' . $pageoptions["TagName"] . ' class="' . $pageoptions["CssClass"] . '">';
            if($show_row_count){
                $html .= '<a class="page_item tj">当前第 ' . $page_no . '/' .$totalpage .' 页,共 '. $row_count .' 条</a>&nbsp;';
            }
            $html .= '</' . $pageoptions["TagName"] . '>';
            return $html;
        }

        if ($totalpage <= 1) {
            if (isset($pageoptions["AutoHide"]) && $pageoptions["AutoHide"] == 1)
                return;
        }

        $PageIndexParameterName = "page_no";
        if (isset($pageoptions["PageIndexParameterName"])) {
            $PageIndexParameterName = $pageoptions["PageIndexParameterName"];
        }
        $cur_page = intval($page_no);
        if ($cur_page < 1) {
            $cur_page = 1;
        }
        if ($cur_page > $totalpage) {
            $cur_page = $totalpage;
        }

        //$old_url = strtolower('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $old_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = $old_url;
        if (stripos($old_url, $PageIndexParameterName . "=") === false) {
            if (stripos($old_url, "?") === false)
                $url .= "?" . $PageIndexParameterName . "=1";
            else $url .= "&" . $PageIndexParameterName . "=1";
        }

        if (isset($pageoptions["IsAjax"]) && $pageoptions["IsAjax"] == 1) {
            $onclick = 'onclick="$(\'#' . $pageoptions["TargetId"] . '\').load($(this).attr(\'href\'));return false;"';
            if (isset($pageoptions["OnBegin"]) && isset($pageoptions["OnComplete"])) {
                $target_Id = $pageoptions["TargetId"];
                $on_begin = $pageoptions["OnBegin"];
                $on_complete = $pageoptions["OnComplete"];
                $onclick = 'onclick=\'$.ajax({type: "get",url: $(this).attr("href"),success: function(data){ $("#' . $target_Id . '").html(data); },beforeSend:function(){ ' . $on_begin . ' },complete:function(){ ' . $on_complete . ' }}); return false;\'';
                //echo $onclick;
            }
        }

        $reg = "/" . $PageIndexParameterName . "=" . $cur_page . "/i";
        if (isset($pageoptions["ShowFirstLast"]) && $pageoptions["ShowFirstLast"] == 1) {
            if (isset($pageoptions["FirstPageText"])) $first_text = $pageoptions["FirstPageText"];
            else $first_text = "&laquo;";
            if (isset($pageoptions["LastPageText"])) $last_text = $pageoptions["LastPageText"];
            else $last_text = "&raquo;";

            $href = preg_replace($reg, $PageIndexParameterName . "=1", $url, 1);
            if ($cur_page <= 1)
                $firstPage = "<a class='page_item' disabled='disabled'>" . $first_text . "</a>&nbsp;";
            else
                $firstPage = "<a class='page_item' href='" . $href . "' " . $onclick . ">" . $first_text . "</a>&nbsp;";

            $href = preg_replace($reg, $PageIndexParameterName . "=" . $totalpage, $url, 1);
            if ($cur_page >= $totalpage)
                $lastPage = "<a class='page_item' disabled='disabled'>" . $last_text . "</a>&nbsp;";
            else
                $lastPage = "<a class='page_item' href='" . $href . "' " . $onclick . ">" . $last_text . "</a>&nbsp;";
        }
        if (isset($pageoptions["ShowPrevNext"]) && $pageoptions["ShowPrevNext"] == 1) {
            $pre_num = $cur_page - 1;
            $next_num = $cur_page + 1;

            if (isset($pageoptions["PrevPageText"])) $prev_text = $pageoptions["PrevPageText"];
            else $prev_text = "&lsaquo;";
            if (isset($pageoptions["NextPageText"])) $next_text = $pageoptions["NextPageText"];
            else $next_text = "&rsaquo;";

            if ($pre_num < 1) {
                $pre_num = 1;
            }
            if ($next_num > $totalpage) {
                $next_num = $totalpage;
            }

            $href = preg_replace($reg, $PageIndexParameterName . "=" . $pre_num, $url, 1);
            if ($cur_page <= $pre_num)
                $prevPage = "<a class='prev' disabled='disabled'><b></b>" . $prev_text . "</a>&nbsp;";
            else
                $prevPage = "<a class='prev' href='" . $href . "' " . $onclick . "><b></b>" . $prev_text . "</a>&nbsp;";

            $href = preg_replace($reg, $PageIndexParameterName . "=" . $next_num, $url, 1);
            if ($cur_page >= $totalpage)
                $nextPage = "<a class='next' disabled='disabled'>" . $next_text . "<b></b></a>&nbsp;";
            else
                $nextPage = "<a class='next' href='" . $href . "' " . $onclick . ">" . $next_text . "<b></b></a>&nbsp;";
        }
        $pageIndexBox = '';
        if ($totalpage > 1 && isset($pageoptions["ShowMorePagerItems"]) && $pageoptions["ShowMorePagerItems"] == 1) {
            $GoToPageScript = "<script type='text/javascript'> function _MvcPager_GoToPage(_pib,_mp){var pageIndex;if(_pib.tagName==\"SELECT\"){pageIndex=_pib.options[_pib.selectedIndex].value;}else{pageIndex=_pib.value;var r=new RegExp(\"^\\\\s*(\\\\d+)\\\\s*$\");if(!r.test(pageIndex)){alert('索引页无效');return;}else if(RegExp.$1<1||RegExp.$1>_mp){alert('索引页无效');return;}}var _hl=document.getElementById(_pib.id+'link').childNodes[0];var _lh=_hl.href;_hl.href=_lh.replace('*_MvcPager_PageIndex_*',pageIndex);if(_hl.click){_hl.click();}else{var evt=document.createEvent('MouseEvents');evt.initEvent('click',true,true);_hl.dispatchEvent(evt);}_hl.href=_lh;}";
            $KeyDownScript = " function _MvcPager_Keydown(e){var _kc,_pib;if(window.event){_kc=e.keyCode;_pib=e.srcElement;}else if(e.which){_kc=e.which;_pib=e.target;}var validKey=(_kc==8||_kc==46||_kc==37||_kc==39||(_kc>=48&&_kc<=57)||(_kc>=96&&_kc<=105));if(!validKey){if(_kc==13){ _MvcPager_GoToPage(_pib," . $totalpage . ");}if(e.preventDefault){e.preventDefault();}else{event.returnValue=false;}}} </script>";
            $href = preg_replace($reg, $PageIndexParameterName . "=*_MvcPager_PageIndex_*", $url, 1);
            $pageIndexBox = '<div class="page_index_box">共' . $totalpage . '页，到第<input id="_MvcPager_Ctrl0_pib" type="text" onkeydown="_MvcPager_Keydown(event)" value="' . $cur_page . '" class="page_text">页<input type="button" onclick="_MvcPager_GoToPage(document.getElementById(\'_MvcPager_Ctrl0_pib\'),' . $totalpage . ')" value="' . $pageoptions["GoButtonText"] . '" class="page_btn"><span id="_MvcPager_Ctrl0_piblink" style="display:none;width:0px;height:0px"><a ' . $onclick . ' href="' . $href . '"></a></span></div>';
            $pageIndexBox .= $GoToPageScript . $KeyDownScript;
        }

        $html = '<' . $pageoptions["TagName"] . ' class="' . $pageoptions["CssClass"] . '">';

        $html .= $firstPage;
        $html .= $prevPage;

        if (isset($pageoptions["ShowNumericPagerItems"]) && $pageoptions["ShowNumericPagerItems"] == 1 && $totalpage > 1) {
            $NumericPagerItemCount = 10;
            if (isset($pageoptions["NumericPagerItemCount"])) {
                $NumericPagerItemCount = $pageoptions["NumericPagerItemCount"];
            }

            $avg_num = floor($NumericPagerItemCount / 2);
            if ($totalpage > $NumericPagerItemCount) { //如果总页数大于5 把当前页置中,判断前后相差多少页
                $pre_sub = 0;
                if ($totalpage - ($cur_page + $avg_num) < 0) {
                    $pre_sub = ($cur_page + $avg_num) - $totalpage;
                }
                $i = ($cur_page - $avg_num > 0 ? $cur_page - $avg_num : 1) - $pre_sub;
                $condition = $i + $avg_num * 2;
            } else {
                $i = 1;
                $condition = $NumericPagerItemCount;
            }

            //AddMoreBefore
            if ($i > 1 && isset($pageoptions["ShowMorePagerItems"]) && $pageoptions["ShowMorePagerItems"] == 1) {
                $href = preg_replace($reg, $PageIndexParameterName . "=" . ($i - 1), $url, 1);
                $html .= '<a class="page_more_before" href="' . $href . '" ' . $onclick . '>' . $pageoptions["MorePageText"] . '</a>&nbsp;';
            }

            for (; $i <= $totalpage && $i <= $condition; $i++) {
                if ($cur_page == $i) {
                    $html .= "<span class='cur'>$cur_page</span>&nbsp;";
                } else {
                    $href = preg_replace($reg, $PageIndexParameterName . "=" . $i, $url, 1);
                    $html .= '<a class="page_item" href="' . $href . '" ' . $onclick . '>' . $i . '</a>&nbsp;';
                }
            }

            //AddMoreAfter
            if ($condition < $totalpage && isset($pageoptions["ShowMorePagerItems"]) && $pageoptions["ShowMorePagerItems"] == 1) {
                $href = preg_replace($reg, $PageIndexParameterName . "=" . ($condition + 1), $url, 1);
                $html .= '<a class="page_more_after" href="' . $href . '" ' . $onclick . '>' . $pageoptions["MorePageText"] . '</a>&nbsp;';
            }
        }

        $html .= $nextPage;
        $html .= $lastPage;
        $html .= $pageIndexBox;

        if($show_row_count){
            $html .= '<a class="page_item tj">当前第 ' . $page_no . '/' .$totalpage .' 页,共 '. $row_count .' 条</a>&nbsp;';
        }

        $html .= '</' . $pageoptions["TagName"] . '>';

        return $html;
    }

}