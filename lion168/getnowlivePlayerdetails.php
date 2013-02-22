<?php
require_once(dirname(__FILE__).'/config2.php');
echo '<script text="text/javascrit">';
echo 'window.opener=null;';
echo "window.open('','_self');";
echo 'window.close();';
echo '</script>';
echo '<script text="text/javascrit">';
echo 'function clock(){i=i-1 document.title="本窗口将在"+i+"秒后自动关闭!";';
echo "if(i>0)setTimeout('clock();',1000);else self.close();}";
echo 'var i=20 clock();';
echo '</script>';
