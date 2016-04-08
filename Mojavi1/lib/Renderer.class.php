<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class Renderer
{

    var $_attributes;

    // controller instance
    var $_controller;

    // mojavi array
    var $_mojavi;

    // request instance
    var $_request;

    // template
    var $_template;

    // user instance
    var $_user;

    /**
     * Create a new Renderer instance.
     *
     * @param controller Controller instance.
     * @param template   Template file.
     */
    function & Renderer (&$controller, $template = NULL)
    {

        $this->_attributes =  array();
        $this->_controller =& $controller;
        $this->_mojavi     =& $controller->getMojavi();
        $this->_request    =& $controller->getRequest();
        $this->_template   =& $template;
        $this->_user       =& $controller->getUser();

    }

    /**
     * Render the view.
     */
    function execute ()
    {

        if ($this->_template == NULL)
        {

            trigger_error('Template has not been specified.', E_USER_ERROR);
            exit;

        }

        $file = ($this->isTemplateAbsolute())
                ? $this->_template
                : $this->_controller->getModuleDir() .
                  'templates/' . $this->_template;

        if (file_exists($file) && is_readable($file))
        {

            // make it easier to access data directly in the template
            $controller =& $this->_controller;
            $mojavi     =& $this->_request->getAttribute('org.mojavi');
            $request    =& $this->_request;
            $template   =& $this->_attributes;
            $user       =& $this->_user;

            require($file);

        } else
        {

            trigger_error("Template file $file does not exist or is not
                          readable.", E_USER_ERROR);
            exit;

        }

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
     * Determine if the template path is absolute.
     */
    function isTemplateAbsolute ()
    {

        $file = __FILE__;

        // determine if we're on unix/linux or windows
        $nix = ($file[0] == '/') ? TRUE : FALSE;

        if (($nix && $this->_template[0] == '/') ||
            (!$nix && ($this->_template[1] == ':' ||
             $this->_template[0] == "\\")))
        {

            return TRUE;

        }

        return FALSE;

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

        $this->_attributes[$name] = $value;

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
     * Set the template.
     *
     * @param template Template file.
     */
    function setTemplate ($template)
    {

        $this->_template = $template;

    }

}

?>
