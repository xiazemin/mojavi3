<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class SmartyRenderer extends Renderer
{

    var $_smarty;

    /**
     * Create a new SmartyRenderer instance.
     *
     * @param controller Controller instance.
     * @param params     Smarty initialization parameters.
     * @param template   Template file.
     */
    function SmartyRenderer (&$controller, $params, $template = NULL)
    {

        parent::Renderer($controller, $template);

        require_once(SMARTY_DIR . 'Smarty.class.php');

        $this->_smarty =& new Smarty;

        // apply Smarty settings
        $keys  = array_keys($params);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->_smarty->$keys[$i] =& $params[$keys[$i]];

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

        $this->_smarty->assign_by_ref('controller', $this->_controller);
        $this->_smarty->assign_by_ref('mojavi', $mojavi);
        $this->_smarty->assign_by_ref('request', $this->_request);
        $this->_smarty->assign_by_ref('user', $this->_user);

        $file = ($this->isTemplateAbsolute())
                ? $this->_template
                : $this->_controller->getModuleDir() .
                 'templates/' . $this->_template;

        if (file_exists($file) && is_readable($file))
        {

            $this->_smarty->display($this->_template);

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

        $attribute =& $this->_smarty->get_template_vars($name);

        if ($attribute != NULL)
        {

            return $attribute;

        }

        return NULL;

    }

    /**
     * Retrieve the Smarty instance this render is using.
     */
    function & getSmarty ()
    {

        return $this->_smarty;

    }

    /**
     * Remove an attribute.
     *
     * @param name Attribute name.
     */
    function removeAttribute ($name)
    {

        $this->_smarty->clear_assign($name);

    }

    /**
     * Set an attribute.
     *
     * @param name  Attribute name.
     * @param value Attribute value.
     */
    function setAttribute ($name, $value)
    {

        $this->_smarty->assign($name, $value);

    }

    /**
     * Set an attribute by reference.
     *
     * @param name  Attribute name.
     * @param value Attribute value.
     */
    function setAttributeByRef ($name, &$value)
    {

        $this->_smarty->assign_by_ref($name, $value);

    }

}

?>
