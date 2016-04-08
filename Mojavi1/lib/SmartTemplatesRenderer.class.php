<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class SmartTemplatesRenderer extends Renderer
{

    var $_smart;

    /**
     * Create a new SmartTemplatesRenderer instance.
     *
     * @param controller Controller instance.
     * @param params     SmartTemplate initialization parameters.
     * @param template   Template file.
     */
    function SmartTemplatesRenderer (&$controller, $params, $template = NULL)
    {

        parent::Renderer($controller, $template);

        require_once(SMART_TEMPLATES_DIR . 'class.smarttemplate.php');

        $this->_smart =& new SmartTemplate;

        // apply SmartTemplate settings
        $keys  = array_keys($params);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->_smart->$keys[$i] =& $params[$keys[$i]];

        }

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

        // set template dir
        $this->_smarty->template_dir = $this->_controller->getModuleDir() .
                                       '/templates';

        // assign smarty variables
        $mojavi =& $this->_request->getAttribute('org.mojavi');

        $this->setAttributeByRef('controller', $this->_controller);
        $this->setAttributeByRef('mojavi', $mojavi);
        $this->setAttributeByRef('request', $this->_request);
        $this->setAttributeByRef('user', $this->_user);

        $file = ($this->isTemplateAbsolute())
                ? $this->_template
                : $this->_controller->getModuleDir() .
                  'templates/' . $this->_template;

        if (file_exists($file) && is_readable($file))
        {

            $this->_smart->template_dir = dirname($file);
            $this->_smart->set_templatefile(basename($file));
            $this->_smart->output();

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

        if (isset($this->_smart->data[$name]))
        {

            $attribute =& $this->_smart->data[$name];

            return $attribute;

        }

        return NULL;

    }

    /**
     * Retrieve the SmartTemplate instance this render is using.
     */
    function & getSmartTemplate ()
    {

        return $this->_smart;

    }

    /**
     * Remove an attribute.
     *
     * @param name Attribute name.
     */
    function removeAttribute ($name)
    {

        if (isset($this->_smart->data[$name]))
        {

            unset($this->_smart->data[$name]);

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

        $this->_smart->assign($name, $value);

    }

    /**
     * Set an attribute by reference.
     *
     * @param name  Attribute name.
     * @param value Attribute value.
     */
    function setAttributeByRef ($name, &$value)
    {

        $this->_smart->data[$name] =& $value;

    }

}

?>
