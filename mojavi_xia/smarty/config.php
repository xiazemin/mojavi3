<?php
define('BASE_PATH','D:/MyProgramAndDocument/php/mojavi_xia/');//����������ľ���·��
define('SMARTY_PATH','smarty/');//����smartyĿ¼�ľ���·��
//echo  BASE_PATH.SMARTY_PATH.'Smarty.class.php'.'<br/>';
date_default_timezone_set('Asia/Chongqing');


require BASE_PATH.SMARTY_PATH.'Smarty.class.php';//����smarty����ļ�
$smarty = new Smarty;//ʵ����һ��smarty����
$smarty->caching = true;
$smarty->cache_lifetime = 120; //����ʱ��
$smarty->template_dir = BASE_PATH.SMARTY_PATH.'templates/';    //html�ļ���ŵ�λ��
$smarty->compile_dir = BASE_PATH.SMARTY_PATH.'templates_c/';  //�����ļ�ָ����Ŀ¼
$smarty->config_dir = BASE_PATH.SMARTY_PATH.'configs/';  //�����ļ�ָ����Ŀ¼
$smarty->cache_dir = BASE_PATH.SMARTY_PATH.'cache/';  //�����ļ�ָ����Ŀ¼
$smarty -> left_delimiter = "{"; //�󶨽�� 
$smarty -> right_delimiter = "}"; //�Ҷ���� 

?>