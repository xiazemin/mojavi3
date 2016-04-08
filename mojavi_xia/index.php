<?php
echo 'hello'.'<br/>';
echo __FILE__ .'<br/>';
echo __DIR__.'<br/>';
echo "dir<br/>"
?>

<?php
//define mojavi dir
define('MO_APP_DIR', 'D:/MyProgramAndDocument/php/mojavi'); 
//ini_set("MO_APP_DIR", "D:/MyProgramAndDocument/php/axb/mojavi");　　　　　
define('APP_DIR', 'D:/MyProgramAndDocument/php/axb/vip');
//set_include_path('D:/MyProgramAndDocument/php/mojavi' . PATH_SEPARATOR .'/mojavi');

echo  MO_APP_DIR ;
echo '<br/>';
echo dirname(__FILE__).'<br/>';


date_default_timezone_set('Asia/Chongqing');
//ini_set("session.gc_maxlifetime", "30");
set_time_limit(0);
// +---------------------------------------------------------------------------+
// | An absolute filesystem path to our webapp/config.php script.              |
// +---------------------------------------------------------------------------+
require_once(APP_DIR."/webapp/config.php");
require_once(APP_DIR."/webapp/language/Tools.class.php");
// +---------------------------------------------------------------------------+
// | An absolute filesystem path to the mojavi/mojavi.php script.              |
// +---------------------------------------------------------------------------+
require_once(MO_APP_DIR."/mojavi.php");

echo  MO_APP_DIR ;
echo '定义的根目录<br/>';
echo  APP_DIR ;
echo '<br/>';
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