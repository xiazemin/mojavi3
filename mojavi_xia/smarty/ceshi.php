<?php
  include("config.php");
  $content="����һ������smarty��ҳ��";
  $smarty->assign('title','����ҳ��');
  $smarty->assign('content',$content);
  $smarty->display('ceshi.html');
?>