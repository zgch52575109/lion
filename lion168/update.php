<?php
require_once(dirname(__FILE__).'/include/common3.php');
echo '<script text="text/javascrit">';
echo 'window.opener=null;';
echo "window.open('','_self');";
echo 'window.close();';
echo '</script>';

