<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class User
{

    var $_attributes;
    var $_privileges;

    /**
     * Create a new User instance.
     *
     * @param container Data persistence container.
     */
    function & User ()
    {

        if (USE_SESSIONS)
        {

            session_start();

            if (!isset($_SESSION['attributes']))
            {

                $_SESSION['attributes'] = array();

            }

            $this->_attributes =& $_SESSION['attributes'];

            if (!isset($_SESSION['privileges']))
            {

                $_SESSION['privileges'] = array();

            }

            $this->_privileges =& $_SESSION['privileges'];

        } else
        {

            // use a temp array for the attributes and privileges
            // this will not allow data to persist from page to page
            $this->_attributes = array();
            $this->_privileges = array();

        }

    }

    /**
     * Add a privilege.
     *
     * @param name      Privilege name.
     * @param namespace Privilege namespace.
     */
    function addPrivilege ($name, $namespace = NULL)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        $this->_privileges[$name] = TRUE;

    }

    /**
     * Retrieve an attribute.
     *
     * @param name      Attribute name.
     * @param namespace Attribute namespace.
     *
     * @return a value, if an attribute with the given name and
     *         namespace exists, otherwise NULL.
     */
    function & getAttribute ($name, $namespace = NULL)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        if (isset($this->_attributes[$name]))
        {

            return $this->_attributes[$name];

        }

        return NULL;

    }

    /**
     * Determine if the user has a privilege.
     *
     * @param name      Privilege name.
     * @param namespace Privilege namespace.
     *
     * @return TRUE, if the user has the given privilege, otherwise FALSE.
     */
    function hasPrivilege ($name, $namespace)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        if (isset($this->_privileges[$name]) &&
            $this->_privileges[$name] == TRUE)
        {

            return TRUE;

        }

        return FALSE;

    }

    /**
     * Determine the authenticated status of the user.
     *
     * @return TRUE, if the user is authenticated, otherwise FALSE.
     */
    function isAuthenticated ()
    {

        $authenticated =& $this->_attributes['org.mojavi.authenticated'];

        return ($authenticated != NULL && $authenticated == TRUE) ? TRUE
                                                                  : FALSE;

    }

    /**
     * Remove an attribute.
     *
     * @param name      Attribute name.
     * @param namespace Attribute namespace.
     */
    function removeAttribute ($name, $namespace = NULL)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        if (isset($this->_attributes[$name]))
        {

            unset($this->_attributes[$name]);

        }

    }

    /**
     * Remove all attributes within or below a given namespace.
     *
     * NOTE: If a namespace is not given, all attributes will be removed.
     *
     * @param namespace Attribute namespace.
     */
    function removeAttributes ($namespace = NULL)
    {

        $keys  = array_keys($this->_attributes);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            if ($namespace == NULL || $namespace == '' ||
                substr($keys[$i], 0, strlen($namespace)) == $namespace)
            {

                unset($this->_attributes[$keys[$i]]);

            }

        }

    }

    /**
     * Remove a privilege.
     *
     * @param name      Privilege name.
     * @param namespace Privilege namespace.
     */
    function removePrivilege ($name, $namespace = NULL)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        if (isset($this->_privileges[$name]))
        {

            unset($this->_privileges[$name]);

        }

    }

    /**
     * Remove all privileges within or below a given namespace.
     *
     * NOTE: If a namespace is not given, all privileges will be removed.
     *
     * @param namespace Privilege namespace.
     */
    function removePrivileges ($namespace = NULL)
    {

        $keys  = array_keys($this->_privileges);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            if ($namespace == NULL || $namespace == '' ||
                substr($keys[$i], 0, strlen($namespace)) == $namespace)
            {

                unset($this->_privileges[$keys[$i]]);

            }

        }

    }

    /**
     * Set an attribute.
     *
     * @param name      Attribute name.
     * @param value     Attribute value.
     * @param namespace Attribute namespace.
     */
    function setAttribute ($name, $value, $namespace = NULL)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        $this->_attributes[$name] =& $value;

    }

    /**
     * Set an attribute by reference.
     *
     * @param name      Attribute name.
     * @param value     Attribute value.
     * @param namespace Attribute namespace.
     */
    function setAttributeByRef ($name, &$value, $namespace = NULL)
    {

        if ($namespace != NULL)
        {

            $name = "$namespace.$name";

        }

        $this->_attributes[$name] =& $value;

    }

    /**
     * Set the authenticated status of this user.
     *
     * @param status Authenticated status.
     */
    function setAuthenticated ($status)
    {

        $this->_attributes['org.mojavi.authenticated'] =& $status;

    }

}

?>