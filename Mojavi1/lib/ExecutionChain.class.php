<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class ExecutionChain
{

    // chain of all executed actions
    var $_chain;

    // controller instance
    var $_controller;

    // currently executing index
    var $_index;

    // size of the chain
    var $_size;

    /**
     * Create a new ExecutionChain instance.
     *
     * @param controller Controller instance.
     */
    function & ExecutionChain (&$controller)
    {

        $this->_chain      =  array();
        $this->_controller =& $controller;
        $this->_index      =  -1;
        $this->_size       =  0;

    }

    /**
     * Add a request to the chain.
     *
     * @param modName Module name.
     * @param actName Action name.
     * @param action  Action instance.
     */
    function addRequest ($modName, $actName, $action)
    {

        $this->_chain[$this->_size] = array('module_name'     => $modName,
                                            'action_name'     => $actName,
                                            'action'          => &$action,
                                            'microtime' => microtime());
        $this->_size++;

    }

    /**
     * Retrieve the action instance associated with the request at the given index.
     *
     * @param index Index from which you wish to retrieve.
     *
     * @return Action instance, if the given index exists, otherwise NULL.
     */
    function & getAction ($index)
    {

        if ($this->_size > $index && $index > -1)
        {

            return $this->_chain[$index]['action'];

        }

        return NULL;

    }

    /**
     * Retrieve the action name associated with the request at the given index.
     *
     * @param index Index from which you wish to retrieve.
     *
     * @return action name, if the given index exists, otherwise NULL.
     */
    function getActionName ($index)
    {

        if ($this->_size > $index && $index > -1)
        {

            return $this->_chain[$index]['action_name'];

        }

        return NULL;

    }

    /**
     * Retrieve the index of the currently executing request.
     */
    function getIndex ()
    {

        return $this->_index;

    }

    /**
     * Retrieve the module name associated with the request at the given index.
     *
     * @param index Index from which you wish to retrieve.
     *
     * @return module name, if the given index exists, otherwise NULL.
     */
    function getModuleName ($index)
    {

        if ($this->_size > $index && $index > -1)
        {

            return $this->_chain[$index]['module_name'];

        }

        return NULL;

    }

    /**
     * Retrieve a request and its associated data.
     *
     * @param index Index from which you wish to retrieve.
     *
     * @return an array containing three keys. the first key 'action' is the
     *         action name. the second key 'module' is the module name. the
     *         third key 'uri' is the fully requested URI (Uniform Resource
     *         Indicator). if the given index does not exist, NULL is returned.
     */
    function getRequest ($index)
    {

        if ($this->_size > $index && $index > -1)
        {

            return $this->_chain[$index];

        }

        return NULL;

    }

    /**
     * Retrieve all requests and their associated data.
     *
     * @return a multi-dimensional array, where the value of each index
     *         is also an array containing data for that particular index.
     *         for a description of the array, view getAction().
     */
    function getRequests ()
    {

        return $this->_chain;

    }

    /**
     * Retrieve the size of the chain.
     */
    function getSize ()
    {

        return $this->_size;

    }

    /**
     * Set the index of the currently executing request.
     *
     * @param index Index.
     */
    function setIndex ($index)
    {

        $this->_index = $index;

    }

}

?>
