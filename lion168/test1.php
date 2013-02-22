<?php

function getWeekRange($date)
  {
    $ret=array();
    $timestamp=strtotime($date);
    $w=strftime('%u',$timestamp);
    $ret['sdate']=date('Y-m-d 00:00:00',$timestamp-($w-1)*86400);
    $ret['edate']=date('Y-m-d 23:59:59',$timestamp+(7-$w)*86400);
    return $ret;
}
//author:zhxia 获取指定日期所在月的开始日期与结束日期
function getMonthRange($date){
$ret=array();
$timestamp=strtotime($date);
$mdays=date('t',$timestamp);
$ret['sdate']=date('Y-m-1 00:00:00',$timestamp);
$ret['edate']=date('Y-m-'.$mdays.' 23:59:59',$timestamp);
return $ret;
}

//author:zhxia 以上两个函数的应用
function getFilter($n){
$ret=array();
switch($n){
case 1:// 昨天
$ret['sdate']=date('Y-m-d 00:00:00',strtotime('-1 day'));
$ret['edate']=date('Y-m-d 23:59:59',strtotime('-1 day'));
break;
case 2://本星期
$ret=getWeekRange(date('Y-m-d'));
break;
case 3://上一个星期
$strDate=date('Y-m-d',strtotime('-1 week'));
$ret=getWeekRange($strDate);
break;
case 4: //上上星期
$strDate=date('Y-m-d',strtotime('-2 week'));
$ret=getWeekRange($strDate);
break;
case 5: //本月
$ret=getMonthRange(date('Y-m-d'));
break;
case 6://上月
$strDate=date('Y-m-d',strtotime('-1 month'));
$ret=getMonthRange($strDate);
break;
}
return $ret;
}

 
$a = getWeekRange(date("Y-m-d h:i:s"));

echo $a['sdate'];
echo $a['edate'];
?>