<?php

namespace Authentication\Controller;

use CoreZend\Controller\AbstractController;
use Authentication\Form\Login as LoginForm;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $form = new LoginForm();
        $form->makeElement();
        return $this->controlAfterSubmit(
            $form,
            'Authentication\Service\Authentication',
            'login',
            'home'
        );
    }

    public function logoffAction()
    {
        $authenticationService = new AuthenticationService();
        $authenticationService->clearIdentity();
        return $this->redirect()->toRoute('authentication');
    }
}
