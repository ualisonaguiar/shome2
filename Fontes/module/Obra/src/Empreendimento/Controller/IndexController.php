<?php

namespace Empreendimento\Controller;

use CoreZend\Controller\AbstractCrudController;
use Empreendimento\Form\ManterEmpreendimento as ManterEmpreendimentoForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Entity\Empreendimento as EmpreendimentoEntity;

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
        $form->prepareElementSearch($this->getEstado());
        return new ViewModel(['form' => $form]);
    }
    
    public function addAction()
    {
        $form = new ManterEmpreendimentoForm();
        $form->prepareElementManter($this->getEstado(), false);        
        return $this->controlAfterSubmit($form, $this->service, 'save', 'empreendimento-obra', 'Empreendimento cadastrado com sucesso.');
    }
    
    public function editAction()
    {
        $form = new ManterEmpreendimentoForm();
        $form->prepareElementManter($this->getEstado(), false);        
        $intIdEmpreendimento = $this->getEvent()->getRouteMatch()->getParam('idEmpreendimento');
        $empreendimento = $this->getService()->find($intIdEmpreendimento);
        if (!$empreendimento->getInSituacao()) {
            $this->setMessageError('Ação não permitida.');
            return $this->redirect()->toRoute('empreendimento-obra');
        }
        $form->setData($empreendimento, $this->getService('Application\Service\Municipio'));
        return $this->controlAfterSubmit($form, $this->service, 'save', 'empreendimento-obra', 'Empreendimento cadastrado com sucesso.');
    }

    public function ajaxListagemAction()
    {
        $request = $this->getRequest();
        $strHtml = '';
        if ($request->isPost()) {
            $form = new ManterEmpreendimentoForm();
            $form->prepareElementSearch(null);
            $form->setData($request->getPost()->toArray());
            if ($form->isValid()) {
                $arrRegistro = $this->getService()->getListagem($form->getData());
                $viewModel = new ViewModel();
                $viewModel->setTemplate('obra/empreendimento/listagem')
                    ->setVariables($arrRegistro);
                $renderer = $this->getService('Zend\View\Renderer\RendererInterface');
                $strHtml = $renderer->render($viewModel);
            }
        }
        return $this->getResponse()->setContent($strHtml);
    }
    
    public function alterarSituacaoAction()
    {
        $arrResult = array('status' => true, 'message' => 'Situação alterada com sucesso.');
        try {
            $request = $this->getRequest();
            $arrDataPost = $request->getPost()->toArray();
            $this->getService('Empreendimento\Service\Empreendimento')->alterarSituacao($arrDataPost['idEmpreendimento']);
        } catch (\Exception $exception) {
            $arrResul['message'] = $exception->getMessage();
            $arrResul['status'] = false;
        }
        return new JsonModel($arrResult);
    }
    
    protected function getEstado()
    {
        return $this->getService('Application\Service\Estado')
            ->fetchPairs('getIdEstado', 'getDsSigla', array(),array('dsSigla' => 'asc'));        
    }
}
