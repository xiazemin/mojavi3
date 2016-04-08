<?php
date_default_timezone_set('Asia/Chongqing');

define('MO_APP_DIR', 'D:/MyProgramAndDocument/php/mojavi_xia/mojavi3');
define('MO_WEBAPP_DIR', 'D:/MyProgramAndDocument/php/mojavi_xia/mojavi3');
define('MO_CACHE_DIR', 'D:/MyProgramAndDocument/php/mojavi_xia/mojavi3');
define('MO_DEBUG ',TRUE);
require_once(MO_APP_DIR."/mojavi.php");
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

