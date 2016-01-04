<?php

namespace Empreendimento\Controller;

use CoreZend\Controller\AbstractCrudController;
use Empreendimento\Form\ManterEmpreendimento as ManterEmpreendimentoForm;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__);
        $this->form = 'Empreendimento\Form\ManterEmpreendimento';
        $this->service = 'Empreendimento\Service\Empreendimento';
    }

    public function indexAction()
    {
        $form = new ManterEmpreendimentoForm();
        $form->prepareElementSearch();
        return new ViewModel(['form' => $form]);
    }

    public function ajaxListagemAction()
    {
        $form = new ManterEmpreendimentoForm();
        $form->prepareElementSearch();
        return $this->ajaxListagem($form, 'Obra/view/_partial/listagem.phtml');
    }
}
