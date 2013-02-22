<?php
if(!defined('EK_INC'))
{
	exit("Request Error!");
}

if(ipbanned()){
	ShowMsg("您的IP不在本站访问列表里，不能访问本站", "javascript:;");
	exit;
}

update_come_from();
insert_views();