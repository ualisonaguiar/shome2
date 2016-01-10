<?php

namespace Application\Controller;

use CoreZend\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class EnderecoController extends AbstractController
{
    public function getEnderecoCepAction()
    {
        $booStatus = true;
        $strMessage = null;
        $arrCep = array();
        try {
            $request = $this->getRequest();
            $arrData = $request->getPost()->toArray();
            $arrCep = $this->getService('Application\Service\CEP')->pesquisar($arrData['co_cep']);
        } catch (\Exception $exception) {
            $booStatus = false;
            $strMessage = $exception->getMessage();
        }
        return new JsonModel(array('data' => $arrCep, 'status' => $booStatus, 'message' => $strMessage));
    }
    
    public function getListaMunicipioAction()
    {
        $intIdEstado = $this->getEvent()->getRouteMatch()->getParam('idEstado');
        $arrMunicipio = $this->getService('Application\Service\Municipio')
            ->fetchPairsToXmlJson('getIdMunicipio', 'getDsNome', array('idEstado' => $intIdEstado),array('dsNome' => 'asc'));
        return new JsonModel($arrMunicipio);
    }
}
