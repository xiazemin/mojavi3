<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class Action
{

    // controller instance
    var $_controller;

    // mojavi array
    var $_mojavi;

    // request instance
    var $_request;

    // user instance
    var $_user;

    /**
     * Create a new Action instance.
     *
     * @param controller Controller instance.
     */
    function & Action (&$controller)
    {

        $this->_controller =& $controller;
        $this->_mojavi     =& $controller->getMojavi();
        $this->_params     =  array();
        $this->_request    =& $controller->getRequest();
        $this->_user       =& $controller->getUser();

    }

    /**
     * Execute the action.
     *
     * @return one of the defined views or a custom view.
     */
    function execute ()
    {

        trigger_error('Action::execute() must be overridden', E_USER_ERROR);

    }

    /**
     * Retrieve the default view to be displayed when getRequestMethods() does
     * not return the current method.
     *
     * @return one of the defined views or a custom view.
     */
    function getDefaultView ()
    {

        // override this method to return a different default view
        return VIEW_INPUT;

    }

    /**
     * Retrieve the privilege required to access this action.
     *
     * NOTE: NULL can be returned to specify that an action is secure, but does not
     *       require a specific privilege.
     *
     * NOTE: This will only be called if isSecure() returns TRUE.
     *
     * @return an array containing two values. The first is the privilege name.
     *         The second is the namespace in which the privilege resides.
     *         If no privilege is required, NULL is returned.
     */
    function getPrivilege ()
    {

        // override this method to specify a custom privilege
        return NULL;

    }

    /**
     * Retrieve all request methods this action will handle.
     *
     * NOTE: When a request is made for this action with a different request method
     *       than provided here, the view is determined by getDefaultView().
     *
     * @return one of the defined request methods, or multiple.
     */
    function getRequestMethods ()
    {

        // override this method to specify a different set of methods
        return REQ_GET | REQ_POST;

    }

    /**
     * Execute all code that must run if a validation error occurs.
     * This most likely would be useful for logging any useful information
     * or to forward the request to an entirely different action.
     *
     * @return one of the defined views or a custom view.
     */
    function handleError ()
    {

        // override this method to provide custom error handling
        return VIEW_ERROR;

    }

    /**
     * Determine if this action requires the user to be authenticated.
     *
     * @return TRUE, if this action requires authentication, otherwise FALSE.
     */
    function isSecure ()
    {

        // override this method to force security
        return FALSE;

    }

    /**
     * Register individual parameter validators.
     *
     * @param validatorManager ValidatorManager instance.
     */
    function registerValidators (&$validatorManager)
    {

        // override this method to register individual parameter validators
        //
        // NOTE: Only methods that are supported by this action need to set
        //       validators.

        /* switch ($_SERVER['REQUEST_METHOD'])
         * {
         *
         *    case 'GET':
         *
         *        // register GET validators
         *        break;
         *
         *    case 'POST':
         *
         *        // register POST validators
         *
         * }
         */

    }

    /**
     * Validate the request as a whole.
     *
     * NOTE: This method is executed only when all individual parameters validate
     *       successfully, or when no individual parameters have been registered.
     *
     * @return TRUE, if validation completes successfully, otherwise FALSE.
     */
    function validate ()
    {

        // override this method to provide custom validation
        //
        // NOTE: Only methods that are supported by this action need
        //       to handle validation.

        /* switch ($_SERVER['REQUEST_METHOD'])
         * {
         *
         *    case 'GET':
         *
         *        // do GET validation
         *        break;
         *
         *    case 'POST':
         *
         *        // do POST validation
         *
         * }
         */

        return TRUE;

    }

}

?>
