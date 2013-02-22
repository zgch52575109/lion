<?php
//======function.php=====
//======分页函数==========
function show_page($query,$page,$link,$offset)
{
   $db = new mysql();
   $result = $db->query($query);
   $Page_size = $offset;  //取得每页显示的最大订单数
   $count = $db->affected_rows($result);   //总订单数
   $page_count  = ceil($count/$Page_size);  //计算得出总页数

   $init=1;
   $page_len=7;
   $max_p=$page_count;
   $pages=$page_count;

   //判断当前页码
   $page=(empty($page)||$page<0)?1:$page;
   $start=$Page_size*($page-1);

   //分页功能代码
   $page_len = ($page_len%2)?$page_len:$pagelen+1;  //页码个数
   $pageoffset = ($page_len-1)/2;  //页码个数左右偏移量

   $key="共 $count 条&nbsp;";
   $key.="$page/$pages &nbsp;";	//第几页,共几页
   if($page!=1){
	     $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1&$link\">第一页</a> ";		//第一页
	     $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."&$link\">上一页</a>";	//上一页
   }
   else 
   {
	     $key.="第一页 ";//第一页
	     $key.="上一页";	//上一页
   }
   if($pages>$page_len)
   {
	     //如果当前页小于等于左偏移
	     if($page<=$pageoffset){
	         $init=1;
	         $max_p = $page_len;
       }
       else  //如果当前页大于左偏移
       {    
           //如果当前页码右偏移超出最大分页数
	         if($page+$pageoffset>=$pages+1){
	              $init = $pages-$page_len+1;
	         }
	         else
	         {
	            //左右偏移都存在时的计算
	            $init = $page-$pageoffset;
	            $max_p = $page+$pageoffset;
	          }
	      }
   }
   for($i=$init;$i<=$max_p;$i++)
   {
       if($i==$page){$key.='&nbsp;['.$i.']';} 
       else {$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."&$link\">".$i."</a>";}
   }
   if($page!=$pages)
   {
       $key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."&$link\">下一页</a> ";//下一页
       $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages."&$link\">最后一页</a>";	//最后一页
   }
   else
   {
       $key.="下一页 ";   //下一页
       $key.="最后一页";	//最后一页
   }
   echo "$key<BR><BR>";
   return $start;
}  
?>