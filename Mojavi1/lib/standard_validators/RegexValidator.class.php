<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class RegexValidator extends Validator
{


    /**
     * Create a new RegexValidator instance.
     *
     * @param controller Controller instance.
     */
    function RegexValidator (&$controller)
    {

        parent::Validator($controller);

        $this->_params['pattern_error'] = 'Pattern does not match';

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

        if (!preg_match($this->_params['pattern'], $value))
        {

            $error = $this->_params['pattern_error'];
            return FALSE;

        }

        return TRUE;

    }

}

?>
