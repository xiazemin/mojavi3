<?php
define('BASE_PATH','D:/MyProgramAndDocument/php/mojavi_xia/');//定义服务器的绝对路径
define('SMARTY_PATH','smarty/');//定义smarty目录的绝度路径
//echo  BASE_PATH.SMARTY_PATH.'Smarty.class.php'.'<br/>';
date_default_timezone_set('Asia/Chongqing');


require BASE_PATH.SMARTY_PATH.'Smarty.class.php';//加载smarty类库文件
$smarty = new Smarty;//实例化一个smarty对象
$smarty->caching = true;
$smarty->cache_lifetime = 120; //缓存时间
$smarty->template_dir = BASE_PATH.SMARTY_PATH.'templates/';    //html文件存放的位置
$smarty->compile_dir = BASE_PATH.SMARTY_PATH.'templates_c/';  //编译文件指定的目录
$smarty->config_dir = BASE_PATH.SMARTY_PATH.'configs/';  //配置文件指定的目录
$smarty->cache_dir = BASE_PATH.SMARTY_PATH.'cache/';  //缓存文件指定的目录
$smarty -> left_delimiter = "{"; //左定界符 
$smarty -> right_delimiter = "}"; //右定界符 

?>