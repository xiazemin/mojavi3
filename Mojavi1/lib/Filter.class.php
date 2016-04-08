<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class Filter
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
     * Create a new Filter instance.
     *
     * @param controller Controller instance.
     */
    function & Filter (&$controller)
    {

        $this->_controller =& $controller;
        $this->_mojavi     =& $controller->getMojavi();
        $this->_params     =  array();
        $this->_request    =& $controller->getRequest();
        $this->_user       =& $controller->getUser();

    }

    /**
     * Execute the filter.
     *
     * @param filterChain Filter chain.
     */
    function execute (&$filterChain)
    {

        trigger_error('Filter::execute($filterChain) must be overridden',
                      E_USER_ERROR);

    }

    /**
     * Initialize the filter.
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
