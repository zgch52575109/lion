<?php
require_once(dirname(__FILE__)."/config.php");
if(empty($action))
{
	$action = '';
}
  

$pagetitle='周周返水';
$rand=$cuserLogin->getUserRank();
$mid=$cuserLogin->getUserID();
$adminname=$cuserLogin->getUserName();
$timestr=time();


$rowu=$dsql->GetOne("SELECT count(*) as all_user FROM `ek_member` where status = 1");
$all_user=$rowu['all_user'];
 



  if ($action == 'add') 
  {
 
       $uid = $_REQUEST['uid'];
       if ($uid > $all_user)
        {
          echo "生成完毕；等待跳转";
          echo "<script>setTimeout(function(){location.href='admin_week.php'},5000); </script>";
          exit();
        }
  
       if (empty($uid))
        {
           $sqlStr="select m.uid,m.username,g.fanshui from ek_member m left join ek_member_group g on g.groupid=m.groupid where m.status = 1  order by m.uid ASC";
        }
       else
        {
           $sqlStr=" select m.uid,m.username,g.fanshui from ek_member m left join ek_member_group g on g.groupid=m.groupid where m.status = 1 and m.uid >= $uid   order by m.uid ASC";
        }
     $dsql->SetQuery($sqlStr);
     $dsql->Execute('class_list');
        $i = 0 ;
		echo  "<h5 style=\"color:green\">请勿关闭页面，自动跳转下一批继续生成，完成后自动跳转</h5>";
        while($row=$dsql->GetArray('class_list'))
          {
              $i++;
             $aid = $row['uid'];
			 $username = $row['username'];
              if($i > 100)
               {                 
                echo "下100个起始生成ID：$aid <a href=\" admin_week.php?action=add&uid=$aid \">手动生成下100个</a>";
		        exit();
               }
			  
			  $rowg = $dsql->GetOne("select lastfanshuitime as lastfanshuitime from `ek_member` where uid=$aid");
	          if(date('YW',$rowg['lastfanshuitime'])!=date('YW',time()-3600*3))
			  {
		           $date1 = strtotime("last Sunday");
		           $date2 = strtotime("last Sunday-7days");
                  //用户投注额度
		          $rowd = $dsql->GetOne("select sum(LiveGameExcludeEvenandTieAmount) as dd from `ek_live_game_bet` where uid=$aid and addtime<='$date1' and addtime>'$date2'");
		          if(is_array($rowd))
				    {
			          $TotalResult = $rowd['dd'];
		            }
					else
					{
			          $TotalResult = 0;
		            }
                 //获取基础返水
		         $rowhj = $dsql->GetOne("select fanshui as fs,maxfanshui as mfs from `ek_member_group` where groupid = $cfg_cl->M_Groupid");
		         $groupdb['fanshui'] = $rowhj['fs'];
		         $groupdb['maxfanshui'] = $rowhj['mfs'];
				 
				 
 
		         $fanshuicash=$TotalResult*$groupdb['fanshui'];
		         $fanshuicash=round($fanshuicash,2);
		         if($fanshuicash>$groupdb['maxfanshui']) $fanshuicash=$groupdb['maxfanshui'];
		         $dsql->ExecuteNoneQuery("update ek_member set money=money+$fanshuicash,lastfanshuitime='".time()."' where uid=$aid");
		        if($fanshuicash>0)
				{
			       $orderid=date('ymdHis').rand(1000,9999);
			       $dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid',$aid,'11','$fanshuicash','".time()."')");//资金记录
			       $dsql->ExecuteNoneQuery("INSERT INTO `ek_member_incash` (orderid,bankid,uid,`type`,bank,hongli,`check`,operation,state,addtime) VALUES ('$orderid','0',$aid,'11','用户钱包','$fanshuicash','2','2','2','".time()."')");//资金记录
				   
				    echo "<h5>用户ID：<span style=\"color:red\">$aid</span> 正在生成用户 <span style=\"color:red\">$username</span> 的周返水;返水金额 <span style=\"color:red\">$fanshuicash</span>；用户投注额<span style=\"color:red\">$TotalResult</span>  </h5>";
                } 
			   else
			   {
				   echo "<h5>用户ID：<span style=\"color:red\">$aid</span> 用户 <span style=\"color:red\">$username</span> 没有返水； </h5>";
				}
					
			  }
			   
		  }
  }





















	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_week.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();


?>