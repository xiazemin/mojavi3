<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class StringValidator extends Validator
{


    /**
     * Create a new StringValidator instance.
     *
     * @param controller Controller instance.
     */
    function StringValidator (&$controller)
    {

        parent::Validator($controller);

        // init settings
        $this->_params['allowed'] = FALSE;
        $this->_params['chars']   = array();
        $this->_params['max']     = -1;
        $this->_params['min']     = -1;
        $this->_params['trim']    = TRUE;

        // init error messages
        $this->_params['chars_error'] = 'Value contains an invalid character';
        $this->_params['max_error']   = 'Value is too long';
        $this->_params['min_error']   = 'Value is not long enough';

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

        $charSize  = sizeof($this->_params['chars']);

        if ($this->_params['trim'])
        {

            $value = trim($value);

        }

        $valLength = strlen($value);

        if ($this->_params['min'] > -1 && $valLength < $this->_params['min'])
        {

            $error = $this->_params['min_error'];
            return FALSE;

        }

        if ($this->_params['max'] > -1 && $valLength > $this->_params['max'])
        {

            $error = $this->_params['max_error'];
            return FALSE;

        }

        if ($charSize > 0)
        {

            for ($i = 0; $i < $valLength; $i++)
            {

                $found = FALSE;

                for ($x = 0; $x < $charSize; $x++)
                {

                    if ($value[$i] == $this->_params['chars'][$x])
                    {

                        $found = TRUE;
                        break;

                    }

                }

                if (($this->_params['allowed'] && !$found) ||
                    (!$this->_params['allowed'] && $found))
                {


                    $error = $this->_params['chars_error'];
                    return FALSE;

                }

            }

        }

        return TRUE;

    }

}

?>
