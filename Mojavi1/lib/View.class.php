<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

// pre-defined views
define('VIEW_ALERT',   'alert');
define('VIEW_ERROR',   'error');
define('VIEW_INDEX',   'index');
define('VIEW_INPUT',   'input');
define('VIEW_NONE',    '');
define('VIEW_SUCCESS', 'success');

class View
{

    // controller instance
    var $_controller;

    // mojavi array
    var $_mojavi;

    // request instance
    var $_request;

    // user instance
    var $_user;

    /**
     * Create a new View instance.
     *
     * @param controller Controller instance.
     */
    function & View (&$controller)
    {

        $this->_controller =& $controller;
        $this->_mojavi     =& $controller->getMojavi();
        $this->_request    =& $controller->getRequest();
        $this->_user       =& $controller->getUser();

    }

    /**
     * Cleanup temporary view data.
     */
    function cleanup ()
    {

        // override this method to provide a custom cleanup sequence

    }

    /**
     * Execute the view.
     *
     * @return a Renderer instance.
     */
    function & execute ()
    {

        trigger_error('View::execute() must be overridden', E_USER_ERROR);

    }

}

?>
