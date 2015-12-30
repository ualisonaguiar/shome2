<?php

namespace CoreZend\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class Authentication extends AbstractHelper
{
    protected $authService;

    public function __invoke()
    {
        $this->authService = new AuthenticationService();
        return $this;
    }

    public function hasIdentity()
    {
        return $this->authService->hasIdentity();
    }

    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }
}
