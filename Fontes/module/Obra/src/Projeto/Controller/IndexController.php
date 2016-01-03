<?php

namespace Projeto\Controller;

use CoreZend\Controller\AbstractCrudController;

class IndexController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__);
        $this->form = 'Projeto\Form\ManterProjeto';
        $this->service = 'Projeto\Service\Projeto';
    }

}
