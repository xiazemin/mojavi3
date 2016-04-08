<?php
  include("config.php");
  $content="这是一个测试smarty的页面";
  $smarty->assign('title','测试页面');
  $smarty->assign('content',$content);
  $smarty->display('ceshi.html');
?>