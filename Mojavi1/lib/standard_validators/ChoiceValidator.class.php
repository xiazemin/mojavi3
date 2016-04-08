<?php

class ChoiceValidator extends Validator
{

    /**
     * Create a new ChoiceValidator instance.
     *
     * @param controller Controller instance.
     */
    function ChoiceValidator (&$controller)
    {

        parent::Validator($controller);

        $this->_params['choices']       = array();
        $this->_params['choices_error'] = 'Invalid value';
        $this->_params['sensitive']     = FALSE;

    }

    /**
     * Execute the validator.
     *
     * @param value Request parameter value.
     * @param error Error message to be set, if an error occurs.
     *
     * @return TRUE, if the validator completes successfully, otherwise FALSE.
     */
    function execute (&$value, &$error)
    {

        $count = sizeof($this->_params['choices']);
        $found = FALSE;

        // loop through the choices, and see if the value is in the list
        for ($i = 0; $i < $count; $i++)
        {

            if ($this->_params['sensitive'])
            {

                if ($value == $this->_params['choices'][$i])
                {

                    $found = TRUE;
                    break;

                }

            } else
            {

                if (strtolower($value) == strtolower($this->_params['choices'][$i]))
                {

                    $found = TRUE;
                    break;

                }

            }

        }

        if (!$found)
        {

            // value wasn't found
            $error = $this->_params['choices_error'];
            return FALSE;

        }

        return TRUE;

    }

}

?>
