<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class GlobalFilterList extends FilterList
{

    /**
     * Create a new GlobalFilterList instance.
     *
     * @param controller Controller instance.
     */
    function & GlobalFilterList (&$controller)
    {

        parent::FilterList($controller);

    }

    /**
     * Register a filter.
     *
     * @param filterChain FilterChain instance.
     */
    function registerFilters (&$filterChain)
    {

        // include global filter classes here

        // require_once(STANDARD_FILTER_DIR . 'ExecutionTimeFilter.class.php');

        // register global filters here

        // $filterChain->register(new ExecutionTimeFilter($this->_controller));

    }

}

?>
