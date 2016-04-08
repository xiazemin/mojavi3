<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class ValidatorManager
{

    // request instance
    var $_request;

    // validators
    var $_validators;

    /**
     * Create a new ValidatorManager instance.
     *
     * @param controller Controller instance.
     */
    function & ValidatorManager (&$controller)
    {

        $this->_request    =& $controller->getRequest();
        $this->_validators =  array();

    }

    /**
     * Execute all validators.
     */
    function execute ()
    {

        $count   = sizeof($this->_validators);
        $success = TRUE;

        for ($i = 0; $i < $count; $i++)
        {

            $error     =  '';
            $param     =& $this->_validators[$i]['param'];
            $required  =& $this->_validators[$i]['required'];
            $validator =& $this->_validators[$i]['validator'];
            $value     =& $this->_request->getParameter($param);

            if ($value != NULL)
            {

                $value = trim($value);

            }

            if (!$required && ($value == NULL || strlen($value) == 0))
            {

                // validation must be bypassed for this parameter

            } else if ($required && ($value == NULL || strlen($value) == 0))
            {

                // no value specified, but it's required
                $this->_request->setError($param, 'Required');
                $success = FALSE;

            } else if (!$this->_request->hasError($param) &&
                       !$validator->execute($value, $error))
            {

                // no previous errors for this parameter and
                // validator failed
                $this->_request->setError($param, $error);
                $success = FALSE;

            }

        }

        return $success;

    }


    /**
     * Register a validator.
     *
     * @param param     Request parameter to be validated.
     * @param validator Validator instance.
     * @param required  Whether or not this parameter is required.
     */
    function register ($param, &$validator, $required = TRUE)
    {

        $index = sizeof($this->_validators);

        $this->_validators[$index]              =  array();
        $this->_validators[$index]['param']     =& $param;
        $this->_validators[$index]['required']  =  ($required) ? TRUE : FALSE;
        $this->_validators[$index]['validator'] =& $validator;

    }

}

?>
