<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class ExecutionTimeFilter extends Filter
{

    /**
     * Create a new ExecutionTimeFilter instance.
     *
     * @param controller Controller instance.
     */
    function & ExecutionTimeFilter (&$controller)
    {

        parent::Filter($controller);

    }

    /**
     * Execute the filter.
     *
     * @param filterChain Filter chain.
     */
    function execute (&$filterChain)
    {

        $loaded =& $this->_request->getAttribute('ExecutionTimeFilter');

        if ($loaded == NULL)
        {

            $this->_request->setAttribute('ExecutionTimeFilter', TRUE);

            ob_start();

            $stimer = explode(' ', microtime());
            $stimer = $stimer[1] + $stimer[0];

            $filterChain->execute();

            $etimer = explode(' ', microtime());
            $etimer = $etimer[1] + $etimer [0];
            $end = round(($etimer - $stimer), 4);

            $content = str_replace('%EXEC_TIME%', $end, ob_get_contents());

            ob_clean();

            echo $content;
            echo "\n<!-- Page was processed in $end milliseconds -->";

            $this->_request->removeAttribute('ExecutionTimeFilter');

        } else
        {

            $filterChain->execute();

        }

    }

}

?>