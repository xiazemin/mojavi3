<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class FilterList
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
     * Create a new FilterList instance.
     *
     * @param controller Controller instance.
     */
    function & FilterList (&$controller)
    {

        $this->_controller =& $controller;
        $this->_mojavi     =& $controller->getMojavi();
        $this->_request    =& $controller->getRequest();
        $this->_user       =& $controller->getUser();

    }

    /**
     * Register global filters or for a specific module.
     *
     * @param filterChain FilterChain instance.
     */
    function registerFilters (&$filterChain)
    {

        trigger_error('FilterList::registerFilters($filterChain) must be
                       overridden', E_USER_ERROR);

    }

}

?>
