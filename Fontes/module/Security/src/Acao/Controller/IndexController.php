<?php

namespace Acao\Controller;

use CoreZend\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Acao\Form\ManterAcao as ManterAcaoForm;

class IndexController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__);
        $this->form = 'Acao\Form\ManterAcao';
        $this->service = 'Acao\Service\Acao';
    }

    public function indexAction()
    {
        return new ViewModel();
//        $form = new ManterPerfilForm();
//        $form->prepareElementSearch();
//        return new ViewModel(array('form' => $form));
    }

    /**
     *
     * @return ViewModel
     */
    public function addAction()
    {
        $form = new ManterAcaoForm();
        $form->prepareElementForm();
        return $this->controlAfterSubmit($form, $this->service, 'save', 'acao', 'Ação cadastrada com sucesso');
    }

    public function editAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
        } else {
            $acao = $this->getService()->find($this->getEvent()->getRouteMatch()->getParam('idAcao'));
            if (!$acao) {
                $this->setMessageError('Ação não encontrado.');
                return $this->redirect()->toRoute('acao');
            }
            $arrData = $acao->toArray();
        }
        $form = new ManterAcaoForm();
        $form->prepareElementForm(true);
        return $this->saveDataAfterSubmit('save', 'acao', 'Ação alterada com sucesso.', $arrData);
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
