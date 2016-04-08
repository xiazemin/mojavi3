<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the           |
// | COPYRIGHT file that was distributed with this source code.                |
// +---------------------------------------------------------------------------+

class ExecutionFilter extends Filter
{

    /**
     * Create a new ExecutionFilter instance.
     *
     * @param controller Controller instance.
     */
    function & ExecutionFilter (&$controller)
    {

        parent::Filter($controller);

    }

    /**
     * Execute this filter.
     *
     * @param filterChain Filter chain.
     */
    function execute (&$filterChain)
    {

        // alias inherited data for easy access
        $controller =& $this->_controller;
        $request    =& $this->_request;
        $user       =& $this->_user;

        $action  =& $this->_request->getAttribute('org.mojavi.action.instance');
        $actName =  $this->_controller->getCurrentAction();
        $modName =  $this->_controller->getCurrentModule();

        // get current method
        switch ($_SERVER['REQUEST_METHOD'])
        {

            case 'GET':

                $method = REQ_GET;
                break;

            case 'POST':

                $method = REQ_POST;

        }

        // does this action require authentication?
        if ($action->isSecure())
        {

            // retrieve the required privilege
            $privilege = $action->getPrivilege();

            if (!$user->isAuthenticated())
            {

                if ($controller->actionExists(AUTH_MODULE, AUTH_ACTION))
                {

                    // this action requires authentication, and the user isn't
                    // authenticated so we'll redirect to login action
                    $controller->handleRequest(AUTH_MODULE, AUTH_ACTION);

                    return;

                }

                // cannot find authentication action
                trigger_error('Authentication module ' . AUTH_MODULE .
                              ' or action ' . AUTH_ACTION . ' does not
                               exist', E_USER_ERROR);
                exit;

            } else if ($privilege != NULL &&
                      !$user->hasPrivilege($privilege[0], $privilege[1]))
            {

                if ($controller->actionExists(SECURE_MODULE,
                                              SECURE_ACTION))
                {

                    // a privilege is required but the user does not have it
                    // redirect to the secure action
                    $controller->handleRequest(SECURE_MODULE,
                                               SECURE_ACTION);
                    return;

                }

                // cannot find secure action
                trigger_error('Secure module ' . SECURE_MODULE . ' action ' .
                              SECURE_ACTION . ' does not exist', E_USER_ERROR);
                exit;

            }

            // user is authenticated, and has the required privilege
            // or no privilege is required

        }

        if (($action->getRequestMethods() & $method) != $method)
        {

            // this action doesn't handle the current request method,
            // use the default view
            $actView = $action->getDefaultView();

        } else
        {

            // create a ValidatorManager instance
            $validManager =& new ValidatorManager($controller);

            // register individual validators
            $action->registerValidators($validManager);

            // check individual validators, and if they succeed,
            // validate entire request
            if (!$validManager->execute() || !$action->validate())
            {

                // one or more individual validators failed or
                // request validation failed
                $actView = $action->handleError();

            } else
            {

                // execute action
                $actView = $action->execute();

            }

            if ($actView == VIEW_NONE)
            {

                // view is VIEW_NONE, which tells us to stop handling
                return;

            }

        }

        if (!$controller->viewExists($modName, $actName, $actView))
        {

            trigger_error("Module $modName does not contain view
                          {$actName}View_$actView or the file is not readable",
                          E_USER_ERROR);
            exit;

        }

        // execute, render and cleanup view
        $view     =& $controller->getView($modName, $actName, $actView);
        $renderer =& $view->execute();

        $renderer->execute();
        $view->cleanup();

        // add the renderer to the request
        $request->setAttributeByRef('org.mojavi.renderer', $renderer);

    }

}

?>