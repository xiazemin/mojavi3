<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

// ----- FILE-SYSTEM DIRECTORIES -----

define('BASE_DIR',  dirname(__FILE__).'\\modules\\');
define('MOJAVI_DIR', dirname(__FILE__).'\\lib\\');

// ----- WEB DIRECTORIES -----

define('WEB_MODULE_DIR', BASE_DIR);

// ----- MODULES AND ACTIONS -----

define('DEFAULT_MODULE', WEB_MODULE_DIR.'actions\\'.'Default');
define('DEFAULT_ACTION', WEB_MODULE_DIR.'actions\\'.'DefaultIndex');

define('ERROR_404_MODULE',WEB_MODULE_DIR.'actions\\'. 'Default');
define('ERROR_404_ACTION',WEB_MODULE_DIR.'actions\\'. 'PageNotFound');

define('AUTH_MODULE',WEB_MODULE_DIR.'templates\\'. 'Default');
define('AUTH_ACTION',WEB_MODULE_DIR.'templates\\'. 'Login');

define('SECURE_MODULE', WEB_MODULE_DIR.'templates\\'.'Default');
define('SECURE_ACTION', WEB_MODULE_DIR.'templates\\'.'GlobalSecure');

// ----- MISC. SETTINGS -----

define('URL_FORMAT',   1);    // 1 == GET_FORMAT, 2 == PATH_FORMAT
define('USE_SESSIONS', TRUE);

// ----- DO NOT MODIFY ANYTHING BELOW THIS LINE -----

require_once(MOJAVI_DIR . 'Action.class.php');
require_once(MOJAVI_DIR . 'ExecutionChain.class.php');
require_once(MOJAVI_DIR . 'Filter.class.php');
require_once(MOJAVI_DIR . 'FilterChain.class.php');
require_once(MOJAVI_DIR . 'FilterList.class.php');
require_once(MOJAVI_DIR . 'Request.class.php');
require_once(MOJAVI_DIR . 'Renderer.class.php');
require_once(MOJAVI_DIR . 'User.class.php');
require_once(MOJAVI_DIR . 'ValidatorManager.class.php');
require_once(MOJAVI_DIR . 'Validator.class.php');
require_once(MOJAVI_DIR . 'View.class.php');
require_once(MOJAVI_DIR . 'Controller.class.php');
require_once(MOJAVI_DIR . 'standard_filters/ExecutionFilter.class.php');

?>
