<?php

echo  substr(md5('123456'),5,20);
echo $_SERVER["REMOTE_ADDR"];


		$date1 = strtotime("last Sunday");
		$date2 = strtotime("last Sunday-7days");
		echo $date1.'<br>'.$date2;
?>