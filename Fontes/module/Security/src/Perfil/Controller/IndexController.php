<?php

namespace Perfil\Controller;

use CoreZend\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Perfil\Form\ManterPerfil as ManterPerfilForm;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__);
        $this->form = 'Perfil\Form\ManterPerfil';
        $this->service = 'Perfil\Service\Perfil';
    }

    public function indexAction()
    {
        $form = new ManterPerfilForm();
        $form->prepareElementSearch();
        return new ViewModel(array('form' => $form));
    }

    /**
     *
     * @return ViewModel
     */
    public function addAction()
    {
        $form = new ManterPerfilForm();
        $form->prepareElementForm();
        return $this->controlAfterSubmit($form, $this->service, 'save', 'perfil', 'Perfil cadastrada com sucesso');
    }

    public function editAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
        } else {
            $perfil = $this->getService()->find($this->getEvent()->getRouteMatch()->getParam('idPerfil'));
            if (!$perfil) {
                $this->setMessageError('Perfil não encontrado.');
                return $this->redirect()->toRoute('perfil');
            }
            $arrData = $perfil->toArray();
        }
        $form = new ManterPerfilForm();
        $form->prepareElementForm(true);
        return $this->saveDataAfterSubmit('save', 'perfil', 'Perfil alterada com sucesso.', $arrData);
    }

    public function ajaxListagemAction()
    {
        $form = new ManterPerfilForm();
        $form->prepareElementSearch();
        return $this->ajaxListagem($form, 'Security/view/_partial/perfil/listagem.phtml');
    }

    public function ajaxAlterarSituacaoAction()
    {
        $request = $this->getRequest();
        $arrResult = array(
            'status' => true,
            'message' => 'Situação do perfil alterado com sucesso.'
        );
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            try {
                $this->getService()->alterarSituacao($arrData['idPerfil']);
            } catch (\Exception $exception) {
                $arrResult['status'] = false;
                $arrResult['message'] = $exception->getMessage();
            }
        }
        return new JsonModel($arrResult);
    }
}
