<?php
//date_default_timezone_set('Asia/Chongqing');
date_default_timezone_set("PRC");

//date_timezone_set($object, $timezone)
require_once(dirname(__FILE__)."\\webapp\\config.php");
/*
 * define('MO_APP_DIR', 'D:/MyProgramAndDocument/php/mojavi3/mojavi');
define('MO_WEBAPP_DIR', 'D:/MyProgramAndDocument/php/mojavi3/webapp');
define('MO_CACHE_DIR', 'D:/MyProgramAndDocument/php/mojavi3/webapp/cache');
define('MO_DEBUG', false);
define('MO_EXCEPTION_FORMAT',0);
*/

//use \Mojavi\Controller;

require_once(MO_APP_DIR."/mojavi.php");

echo dirname(__FILE__);
echo ' <br/><br/>MO_APP_DIR<br/>'.MO_APP_DIR.'<br/>';
echo MO_CONFIG_DIR;
echo MO_LIB_DIR;
echo '<br/><br/>MO_WEBAPP_DIR<br/>'.MO_WEBAPP_DIR.'<br/>';
//require_once(MO_APP_DIR."/Controller/Controller.php");
// +---------------------------------------------------------------------------+
// | Create our controller. For this file we're going to use a front           |
// | controller pattern. This pattern allows us to specify module and action   |
// | GET/POST parameters and it automatically detects them and finds the       |
// | expected action.                                                          |
// +---------------------------------------------------------------------------+
$controller = Controller::newInstance('FrontWebController');

// +---------------------------------------------------------------------------+
// | Dispatch our request.                                                     |
// +---------------------------------------------------------------------------+
$controller->dispatch();
?>
