<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class EmailValidator extends Validator
{

    /**
     * Create a new EmailValidator instance.
     *
     * @param controller Controller instance.
     */
    function EmailValidator (&$controller)
    {

        parent::Validator($controller);

        $this->_params['email_error'] = 'Invalid email address';

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

        if (!preg_match('/^[a-z0-9\-\._]+@[a-z0-9]([0-9a-z\-]*[a-z0-9]\.){1,}[a-z]{2,7}$/i', $value) &&
            !preg_match('/^[a-z0-9\-\._]+@(([0-9]){1,3}\.){3}[0-9]{1,3}$/i', $value))
        {

            $error = $this->_params['email_error'];
            return FALSE;

        }

        return TRUE;

    }

}

?>
