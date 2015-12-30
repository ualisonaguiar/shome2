<?php

namespace Perfil\Controller;

use CoreZend\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Perfil\Form\VincularUsuarioPerfil as VincularUsuarioPerfilForm;
use Zend\View\Model\JsonModel;

class PerfilUsuarioController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->service = 'Perfil\Service\PerfilUsuario';
    }

    public function indexAction()
    {
        try {
            $intIdPerfil = $this->getEvent()->getRouteMatch()->getParam('idPerfil');
            $perfil = $this->getService('Perfil\Service\Perfil')->find($intIdPerfil);
            if (!$perfil) {
                throw new \Exception('Perfil não encontrado.');
            }
            $arrLogin = $this->getService('Perfil\Service\PerfilUsuario')
                ->getListagemLoginNaoVinculado($intIdPerfil);
            $formVinculo = new VincularUsuarioPerfilForm();
            $formVinculo->prepareElementTela($arrLogin);
            $formVinculo->setData(array('idPerfil' => $intIdPerfil));
            return new ViewModel(array('perfil' => $perfil, 'formVinculo' => $formVinculo));
        } catch (\Exception $exception) {
            $this->setMessageError($exception->getMessage());
            return $this->redirect()->toRoute('perfil');
        }
    }

    public function adicionarAction()
    {
        $request = $this->getRequest();
        $arrResult = array('status' => true, 'message' => 'Usuário vinculado com sucesso.');
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            try {
                $arrResult['data'] = $this->getService('Perfil\Service\PerfilUsuario')->save($arrData);
            } catch (\Exception $exception) {
                $arrResult['status'] = false;
                $arrResult['message'] = $exception->getMessage();
            }
        }
        return new JsonModel($arrResult);
    }

    public function removeAction()
    {
        $request = $this->getRequest();
        $arrResult = array('status' => true, 'message' => 'Usuário removido com sucesso.');
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            try {
                $arrResult['data'] = $this->getService('Perfil\Service\PerfilUsuario')->remove($arrData);
            } catch (\Exception $exception) {
                $arrResult['status'] = false;
                $arrResult['message'] = $exception->getMessage();
            }
        }
        return new JsonModel($arrResult);
    }

    public function listagemUsuarioAction()
    {
        $request = $this->getRequest();
        $arrResult = array();
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            $arrResult['data'] = $this->getService('Perfil\Service\PerfilUsuario')
                ->getListagemLoginNaoVinculado($arrData['idPerfil']);
        }
        return new JsonModel($arrResult);
    }
}
