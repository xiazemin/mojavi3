<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

define('GLOBAL_FILTER_DIR',      BASE_DIR . 'filters/');
define('GLOBAL_TEMPLATE_DIR',    BASE_DIR . 'templates/');
define('STANDARD_FILTER_DIR',    MOJAVI_DIR . 'standard_filters/');
define('STANDARD_VALIDATOR_DIR', MOJAVI_DIR . 'standard_validators/');

// format types
define('GET_FORMAT',  1);
define('PATH_FORMAT', 2);

class Controller
{

    // expected content type
    var $_contentType;

    // execution chain
    var $_execChain;

    // mojavi array
    var $_mojavi;

    // request instance
    var $_request;

    // user instance
    var $_user;

    /**
     * Create a new Controller instance.
     */
    function & Controller ()
    {

        $this->_execChain =& new ExecutionChain($this);

    }

    /**
     * Determine if an action exists.
     *
     * @param modName Module name.
     * @param actName Action name.
     *
     * @return TRUE, if the given module has the given action, otherwise
     *         FALSE.
     */
    function actionExists ($modName, $actName)
    {

        $file = BASE_DIR . "modules/$modName/actions/{$actName}Action.class.php";

        if (is_readable($file))
        {

            return TRUE;

        }

        return FALSE;

    }

    /**
     * Dispatch the original request.
     */
    function dispatch ()
    {

        // parse parameters
        $params         =& $this->_parseParameters();
        $this->_request =& new Request($params);
        $this->_mojavi  =  array();
        $this->_user    =& new User;

        // find expected content type
        $contentType =& $this->_request->getParameter('ctype');

        if ($contentType != NULL &&
            preg_match('/^[a-z0-9_]+$/', $contentType))
        {

            $this->_contentType =& $contentType;

        } else
        {

            $this->_contentType = 'html';

        }

        // retrieve the requested module and action
        $actName = $this->_request->getParameter('action');
        $modName = $this->_request->getParameter('module');

        if ($modName == NULL && $actName == NULL)
        {

            // no module has been specified
            $modName = DEFAULT_MODULE;
            $actName = DEFAULT_ACTION;

        } else
        {

            // replace unwanted characters from the module and action
            if ($modName != NULL)
            {

                $modName = preg_replace('/[^a-z0-9_]/i', '', trim($modName));

            }

            if ($actName != NULL)
            {

                $actName = preg_replace('/[^a-z0-9_]/i', '', trim($actName));

            }

            if (($actName == NULL || strlen($actName) == 0) &&
                $this->actionExists($modName, $modName . 'Index'))
            {

                // the module has the default Index action
                $actName = $modName . 'Index';

            }

        }

        // create $mojavi variables
        $this->_mojavi['controller']     =& $this;
        $this->_mojavi['request']        =& $this->_request;
        $this->_mojavi['user']           =& $this->_user;
        $this->_mojavi['current_action'] =  $actName;
        $this->_mojavi['current_module'] =  $modName;
        $this->_mojavi['request_action'] =  $actName;
        $this->_mojavi['request_module'] =  $modName;

        // directories
        $this->_mojavi['base_dir']       =  BASE_DIR;
        $this->_mojavi['filter_dir']     =  GLOBAL_FILTER_DIR;
        $this->_mojavi['module_dir']     =  BASE_DIR . 'modules/';
        $this->_mojavi['mojavi_dir']     =  MOJAVI_DIR;
        $this->_mojavi['template_dir']   =  GLOBAL_TEMPLATE_DIR;
        $this->_mojavi['web_module_dir'] =  WEB_MODULE_DIR;

        // paths
        $this->_mojavi['controller_path']      =  $this->getControllerPath();
        $this->_mojavi['current_action_path']  =  $this->getControllerPath($modName,
                                                                    $actName);
        $this->_mojavi['current_module_path']  =  $this->getControllerPath($modName);
        $this->_mojavi['request_action_path']  =  $this->getControllerPath($modName,
                                                                    $actName);
        $this->_mojavi['request_module_path']  =  $this->getControllerPath($modName);

        // set mojavi attribute
        $this->_request->setAttributeByRef('org.mojavi', $this->_mojavi);

        // time to do the dirty work
        $this->handleRequest($modName, $actName);

    }

    /**
     * Generate a formatted URL.
     *
     * @param params URL parameters.
     * @param format Format to be used.
     * @param encode Encode parameter values?
     */
    function genURL ($params, $format, $encode = TRUE)
    {

        $url = $_SERVER['SCRIPT_NAME'];

        if ($format == PATH_FORMAT)
        {

            $divider  = '/';
            $equals   = '/';
            $url     .= '/';

        } else
        {

            // use an else and not a condition to cover any unknown formats
            $divider  = '&';
            $equals   = '=';
            $url     .= '?';

        }

        $keys  = array_keys($params);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            if ($i > 0)
            {

                $url .= $divider;

            }

            $url .= $keys[$i] . $equals;

            $url = ($encode) ? ($url . urlencode($params[$keys[$i]]))
                             : ($url . $params[$keys[$i]]);

        }

        return $url;

    }

    /**
     * Retrieve an instance of an Action implementation.
     *
     * @param modName Module name.
     * @param actName Action name.
     *
     * @return Action instance.
     */
    function & getAction ($modName, $actName)
    {


        $file = BASE_DIR . "modules/$modName/actions/{$actName}Action.class.php";

        // include action class
        require_once($file);

        $action =  "{$actName}Action";
        $action =& new $action($this);

        return $action;

    }

    /**
     * Retrieve the expected content type.
     */
    function getContentType ()
    {

        return $this->_contentType;

    }

    /**
     * Retrieve an absolute web path to the controller.
     *
     * @param modName Module name.
     * @param actName Action name.
     */
    function getControllerPath ($modName = NULL, $actName = NULL)
    {

        $path = $_SERVER['SCRIPT_NAME'];

        if ($modName != NULL)
        {

            $path .= (URL_FORMAT == GET_FORMAT)
                     ? "?module=$modName"
                     : "/module/$modName";

            if ($actName != NULL)
            {

                $path .= (URL_FORMAT == GET_FORMAT)
                         ? "&action=$actName"
                         : "/action/$actName";

            }

        }

        return $path;

    }

    /**
     * Retrieve the current action.
     *
     * NOTE: If the request has not been forwarded, this will return the request
     *       action.
     */
    function getCurrentAction ()
    {

        return $this->_execChain->getActionName($this->_execChain->getIndex());

    }

    /**
     * Retrieve the current module name.
     *
     * NOTE: If the request has not been forwarded, this will return the request
     *       module.
     */
    function getCurrentModule ()
    {

        return $this->_execChain->getModuleName($this->_execChain->getIndex());

    }

    /**
     * Retrieve the execution chain.
     */
    function & getExecutionChain ()
    {

        return $this->_execChain;

    }

    /**
     * Retrieve an absolute file-system path to the currently executing module.
     *
     * NOTE: If the request has been forwarded, this will return the directory
     *       to the forwarded module.
     */
    function getModuleDir ()
    {

        return (BASE_DIR . 'modules/' .
                $this->_execChain->getModuleName($this->_execChain->getIndex()) . '/');

    }

    /**
     * Retrieve the Mojavi array associated with the controller.
     */
    function & getMojavi ()
    {

        return $this->_mojavi;

    }

    /**
     * Retrieve the Request instance associated with the controller.
     */
    function & getRequest ()
    {

        return $this->_request;

    }

    /**
     * Retrieve the action provided by the original request.
     */
    function getRequestAction ()
    {

        return $this->_execChain->getActionName(0);

    }

    /**
     * Retrieve the module provided by the original request.
     */
    function getRequestModule ()
    {

        return $this->_execChain->getModuleName(0);

    }

    /**
     * Retrieve the User instance associated with the controller.
     */
    function & getUser ()
    {

        return $this->_user;

    }

    /**
     * Retrieve an instance of a View implementation.
     *
     * @param modName Module name.
     * @param actName Action name.
     * @param actView Action view.
     *
     * @param View instance.
     */
    function & getView ($modName, $actName, $actView)
    {

        $file = BASE_DIR . "modules/$modName/views/{$actName}View_$actView.class.php";

        // include view class
        require_once($file);

        $view =  "{$actName}View";
        $view =& new $view($this);

        return $view;

    }

    /**
     * Error handler.
     *
     * NOTE: Register a custom error handler inside index.php, before you dispatch
     *       the request.
     *
     * @param flag    Error flag.
     * @param message Error message.
     * @param file    Error file.
     * @param line    Error line.
     */
    function handleError ($flag, $message, $file, $line)
    {

        // don't want to print supressed errors
        if (error_reporting() > 0)
        {

            switch ($flag)
            {

                case E_USER_NOTICE:

                    echo '<b>NOTICE</b> [' . basename($file) . ":$line] $message";
                    break;

                case E_USER_ERROR:

                    echo '<b>ERROR</b> [' . basename($file) . ":$line] $message";
                    break;

                case E_USER_WARNING:

                    echo '<b>WARNING</b> [' . basename($file) . ":$line] $message";
                    break;

                default:

                    echo '<b>UNKNOWN</b> [' . basename($file) . ":$line] $message";

            }

        }

    }

    /**
     * Handle the current action request.
     *
     * @param modName Module name.
     * @param actName Action name.
     */
    function handleRequest ($modName, $actName)
    {

        if ($actName == NULL)
        {

            $actName = '';

        }

        if (($actName == NULL || $actName == '') &&
             $this->actionExists($modName, 'Index'))
        {

            $actName = 'Index';

        } else if (!$this->actionExists($modName, $actName))
        {

            if ($this->actionExists(ERROR_404_MODULE, ERROR_404_ACTION))
            {

                // module or action does not exist, redirect to error 404 action
                $this->_request->setAttribute('org.mojavi.action', $actName);
                $this->_request->setAttribute('org.mojavi.module', $modName);

                $this->handleRequest(ERROR_404_MODULE, ERROR_404_ACTION);

                return;

            }

            // cannot find 404 action
            trigger_error('Error 404 module ' . ERROR_404_MODULE . ' or action ' .
                          ERROR_404_ACTION . ' does not exist', E_USER_ERROR);
            exit;

        }

        // retrieve the action
        $action =& $this->getAction($modName, $actName);
        $this->_request->setAttributeByRef('org.mojavi.action.instance',
                                           $action);

        // add module and action to execution chain, for tracking
        // purposes and update current vars
        $chainIndex = $this->_execChain->getIndex() + 1;
        $this->_execChain->setIndex($chainIndex);
        $this->_execChain->addRequest($modName, $actName, $action);
        $this->_updateCurrentVars($chainIndex);

        // create a new FilterChain instance
        $filterChain =& new FilterChain($this);

        // map global filters
        $this->_mapGlobalFilters($filterChain);

        // map module filters
        $this->mapModuleFilters($filterChain, $modName);

        // don't forget to add the execution filter
        $execFilter =& new ExecutionFilter($this);
        $filterChain->register($execFilter);

        // execute filters
        $filterChain->execute($this);

        // update current vars
        $this->_updateCurrentVars(--$chainIndex);

    }

    /**
     * Map all filters for a given module.
     *
     * @param filterChain FilterChain instance.
     * @param modName     Module name.
     */
    function mapModuleFilters (&$filterChain, $modName)
    {

        $file = BASE_DIR . "modules/$modName/filters/{$modName}FilterList.class.php";

        if (is_readable($file))
        {

            // include filter mapping class
            require_once($file);

            $filterList =  "{$modName}FilterList";
            $filterList =& new $filterList($this);
            $filterList->registerFilters($filterChain, $this);

            return;

        }

    }

    /**
     * Set the expected content type.
     *
     * @param ctype Content type.
     */
    function setContentType ($ctype)
    {

        $this->_contentType = $ctype;

    }

    /**
     * Determine if a view exists.
     *
     * @param modName Module name.
     * @param actName Action name.
     * @param actView Action view.
     *
     * @return TRUE, if the given action has the given view, otherwise
     *         FALSE.
     */
    function viewExists ($modName, $actName, $actView)
    {

        $file = BASE_DIR . "modules/$modName/views/{$actName}View_$actView.class.php";

        if (is_readable($file))
        {

            return TRUE;

        }

        return FALSE;

    }

    // ----- PRIVATE METHODS -----

    /**
     * Map global filters.
     *
     * @param filterManager FilterManager instance.
     */
    function _mapGlobalFilters (&$filterManager)
    {

        $file = GLOBAL_FILTER_DIR . 'GlobalFilterList.class.php';

        if (is_readable($file))
        {

            // include filter mapping class
            require_once($file);

            $filterList =& new GlobalFilterList($this);
            $filterList->registerFilters($filterManager, $this);

            return;

        }

    }

    /**
     * Parse and retrieve all GET/POST parameters.
     *
     * @return An associative array of GET parameters.
     */
    function & _parseParameters ()
    {

        $values = array();

        // load GET params into $values array
        $keys  = array_keys($_GET);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $values[$keys[$i]] =& $_GET[$keys[$i]];

        }

        // parse REQUEST_URI and grab search engine friendly parameters
        $array    = explode('?', $_SERVER['REQUEST_URI']);
        $pathInfo = substr($array[0], strlen($_SERVER['SCRIPT_NAME']) + 1);
        $getArray = explode('/', $pathInfo);
        $count    = sizeof($getArray);

        for ($i = 0; $i < $count; $i++)
        {

            // must use if statement here because you cannot assign a value
            // to a reference using ternary
            if (isset($getArray[$i + 1]))
            {

                $values[$getArray[$i]] =& $getArray[++$i];

            } else
            {

                $values[$getArray[$i]] = '';

            }

        }

        // load POST params into $values array
        $keys  = array_keys($_POST);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $values[$keys[$i]] =& $_POST[$keys[$i]];

        }

        return $values;

    }

    /**
     * Update current module and action data.
     *
     * @param index   Execution chain index to use for vars.
     */
    function _updateCurrentVars ($index)
    {

        $reqData =  $this->_execChain->getRequest($index);

        $this->_mojavi['current_action']      = $reqData['action_name'];
        $this->_mojavi['current_module']      = $reqData['module_name'];
        $this->_mojavi['current_action_path'] = $this->getControllerPath($reqData['module_name'],
                                                                         $reqData['action_name']);
        $this->_mojavi['current_module_path'] = $this->getControllerPath($reqData['module_name']);

    }

}

?>
