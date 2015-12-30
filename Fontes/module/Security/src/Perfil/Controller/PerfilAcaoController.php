<?php

namespace Perfil\Controller;

use CoreZend\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Perfil\Form\VincularAcaoPerfil as AcaoPerfilForm;

class PerfilAcaoController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->service = 'Perfil\Service\PerfilAcao';
    }

    public function indexAction()
    {
        try {
            $intIdPerfil = $this->getEvent()->getRouteMatch()->getParam('idPerfil');
            $perfil = $this->getService('Perfil\Service\Perfil')->find($intIdPerfil);
            if (!$perfil) {
                throw new \Exception('Perfil não encontrado.');
            }
            $arrAcaoSelect = $this->getService('Perfil\Service\PerfilAcao')
                ->getListagemAcaoNaoVinculado($intIdPerfil);
            $formVinculo = new AcaoPerfilForm();
            $formVinculo->prepareElementTela($arrAcaoSelect);
            $formVinculo->setData(array('idPerfil' => $intIdPerfil));
            return new ViewModel(array('perfil' => $perfil, 'formVinculo' => $formVinculo));
        } catch (\Exception $exception) {
            $this->setMessageError($exception->getMessage());
            return $this->redirect()->toRoute('perfil');
        }
    }

    public function removeAction()
    {
        $request = $this->getRequest();
        $arrResult = array('status' => true, 'message' => 'Ação removido com sucesso.');
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            try {
                $arrResult['data'] = $this->getService('Perfil\Service\PerfilAcao')->remove($arrData);
            } catch (\Exception $exception) {
                $arrResult['status'] = false;
                $arrResult['message'] = $exception->getMessage();
            }
        }
        return new JsonModel($arrResult);
    }

    public function adicionarAction()
    {
        $request = $this->getRequest();
        $arrResult = array('status' => true, 'message' => 'Ação vinculado com sucesso.');
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            try {
                $arrResult['data'] = $this->getService('Perfil\Service\PerfilAcao')->save($arrData);
            } catch (\Exception $exception) {
                $arrResult['status'] = false;
                $arrResult['message'] = $exception->getMessage();
            }
        }
        return new JsonModel($arrResult);
    }
}
