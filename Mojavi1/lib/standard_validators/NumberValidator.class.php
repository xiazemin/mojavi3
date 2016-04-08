<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class NumberValidator extends Validator
{


    /**
     * Create a new NumberValidator instance.
     *
     * @param controller Controller instance.
     */
    function NumberValidator (&$controller)
    {

        parent::Validator($controller);

        // init settings
        $this->_params['max']    = -1;
        $this->_params['min']    = -1;

        // init error messages
        $this->_params['max_error']    = 'Value is too high';
        $this->_params['min_error']    = 'Value is too low';
        $this->_params['number_error'] = 'Value is not numeric';

    }

    /**
     * Execute the validator.
     *
     * @param value Request parameter value.
     * @param error Error message to be set if an error occurs.
     *
     * @return TRUE, if the validator completes successfully, otherwise FALSE.
     */
    function execute (&$value, &$error)
    {

        if (!is_numeric($value))
        {

            $error = $this->_params['number_error'];
            return FALSE;

        }

        if ($this->_params['min'] > -1 && $value < $this->_params['min'])
        {

            $error = $this->_params['min_error'];
            return FALSE;

        }

        if ($this->_params['max'] > -1 && $value > $this->_params['max'])
        {

            $error = $this->_params['max_error'];
            return FALSE;

        }

        return TRUE;

    }

}

?>
