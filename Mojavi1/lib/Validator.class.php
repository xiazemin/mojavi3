<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class Validator
{

    // controller instance
    var $_controller;

    // mojavi array
    var $_mojavi;

    // initialization parameters
    var $_params;

    // request instance
    var $_request;

    // user instance
    var $_user;

    /**
     * Create a new Validator instance.
     *
     * @param controller Controller instance.
     */
    function & Validator (&$controller)
    {

        $this->_controller =& $controller;
        $this->_mojavi     =& $controller->getMojavi();
        $this->_params     =  array();
        $this->_request    =& $controller->getRequest();
        $this->_user       =& $controller->getUser();

    }

    /**
     * Execute the validator.
     *
     * @param value Request parameter value.
     * @param error Error message to be set, if an error occurs.
     *
     * @return TRUE, if the validator completes successfully, otherwise FALSE.
     */
    function execute (&$value, &$error)
    {

        trigger_error('Validator::execute($value, $error) must be overridden',
                      E_USER_ERROR);

    }

    /**
     * Initialize the validator.
     *
     * @param params Initialization parameters.
     */
    function initialize ($params)
    {

        // override this method to provide custom initialization
        $keys  = array_keys($params);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->_params[$keys[$i]] =& $params[$keys[$i]];

        }

    }

}

?>
