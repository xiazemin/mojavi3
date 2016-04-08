<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class FilterChain
{

    // controller instance
    var $_controller;

    // current filter index
    var $_current;

    // filters
    var $_filters;

    // mojavi array
    var $_mojavi;

    // request instance
    var $_request;

    // user instance
    var $_user;

    /**
     * Create a new FilterChain instance.
     *
     * @param controller Controller instance.
     */
    function & FilterChain (&$controller)
    {

        $this->_controller =& $controller;
        $this->_current    =  -1;
        $this->_filters    =  array();
        $this->_mojavi     =& $controller->getMojavi();
        $this->_request    =& $controller->getRequest();
        $this->_user       =& $controller->getUser();

    }

    /**
     * Execute the next filter in the chain.
     */
    function execute ()
    {

        if (++$this->_current < sizeof($this->_filters))
        {

            $this->_filters[$this->_current]->execute($this);

        }

    }

    /**
     * Register a filter.
     *
     * @param filter Filter instance.
     */
    function register (&$filter)
    {

        $this->_filters[] =& $filter;

    }

}

?>