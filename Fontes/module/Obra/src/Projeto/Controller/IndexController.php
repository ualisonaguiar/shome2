<?php

namespace Projeto\Controller;

use CoreZend\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__);
        $this->form = 'Projeto\Form\ManterProjeto';
        $this->service = 'Projeto\Service\Projeto';
    }

    public function indexAction()
    {
        $intIdEmpreendimento = $this->getEvent()->getRouteMatch()->getParam('idEmpreendimento');
        $empreendimento = $this->getService('Empreendimento\Service\Empreendimento')->find($intIdEmpreendimento);
        return new ViewModel(['empreendimento' => $empreendimento]);
    }
}
