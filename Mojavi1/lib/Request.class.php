<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

// request types
define('REQ_NONE', 1);
define('REQ_GET',  2);
define('REQ_POST', 4);

class Request
{

    var $_attributes;
    var $_errors;
    var $_parameters;

    /**
     * Create a new Request instance.
     *
     * @param params Parsed parameters.
     */
    function & Request (&$params)
    {

        $this->_attributes =  array();
        $this->_errors     =  array();
        $this->_parameters =& $params;

    }

    /**
     * Retrieve an attribute.
     *
     * @param name Attribute name.
     *
     * @return a value, if an attribute with the given name exists, otherwise
     *         NULL.
     */
    function & getAttribute ($name)
    {

        if (isset($this->_attributes[$name]))
        {

            return $this->_attributes[$name];

        }

        return NULL;

    }

    /**
     * Retrieve a validation error message.
     *
     * @param name Parameter name.
     *
     * @return an error message, if a validation error exists for the given
     *         parameter, otherwise NULL.
     */
    function getError ($name)
    {

        return (isset($this->_errors[$name])) ? $this->_errors[$name] : NULL;

    }

    /**
     * Retrieve an array of validation errors.
     *
     * @return an array of validation errors where each key is a parameter name.
     */
    function getErrors ()
    {

        return $this->_errors;

    }

    /**
     * Retrieve a parameter.
     *
     * @param name Parameter name.
     *
     * @return a value, if a parameter with the given name exists, otherwise
     *         NULL.
     */
    function getParameter ($name)
    {

        if (isset($this->_parameters[$name]))
        {

            $value =& $this->_parameters[$name];

            if (get_magic_quotes_gpc() == 1)
            {

                $value = stripslashes($value);

            }

            return $value;

        }

        return NULL;

    }

    /**
     * Determine if a validation error has been set for a specific parameter.
     *
     * @param name Parameter name.
     *
     * @return TRUE, if a validation error has been set for the given
     *         parameter, otherwise FALSE.
     */
    function hasError ($name)
    {

        return (isset($this->_errors[$name])) ? TRUE : FALSE;

    }

    /**
     * Remove an attribute.
     *
     * @param name Attribute name.
     */
    function removeAttribute ($name)
    {

        if (isset($this->_attributes[$name]))
        {

            unset($this->_attributes[$name]);

        }

    }

    /**
     * Set an attribute.
     *
     * @param name  Attribute name.
     * @param value Attribute value.
     */
    function setAttribute ($name, $value)
    {

        $this->_attributes[$name] =& $value;

    }

    /**
     * Set an attribute by reference.
     *
     * @param name  Attribute name.
     * @param value Attribute value.
     */
    function setAttributeByRef ($name, &$value)
    {

        $this->_attributes[$name] =& $value;

    }

    /**
     * Set or overwrite a validation error message.
     *
     * @param name    Parameter name.
     * @param message Error message.
     */
    function setError ($name, $message)
    {

        $this->_errors[$name] =& $message;

    }

}

?>
