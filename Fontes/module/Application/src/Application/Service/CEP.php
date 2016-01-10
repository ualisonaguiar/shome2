<?php

namespace Application\Service;

use CoreZend\Service\AbstractServiceCore;
use CoreZend\Util\Format;

class CEP extends AbstractServiceCore
{
    public function pesquisar($strCEP)
    {
        $adapter = $this->getAdapter();
        $arrResult = $adapter->pesquisaCep(Format::clearMask($strCEP));
        if (!$arrResult['status']) {
            throw new \Exception($arrResult['message']);
        }
        $arrResult = $this->makeResult($arrResult);
//        if (array_key_exists('idMunicipio', $arrResult)) {
//            # operacao de cadastro
//        }         
        return $arrResult;
    }
    
    protected function makeResult($arrResult)
    {
        $arrEstado = $this->getService('Application\Service\Estado')->findBy(array('dsSigla' => $arrResult['uf']));
        $arrResult['idEstado'] = $arrEstado[0]->getIdEstado();
        $arrResult['dsSigla'] = $arrEstado[0]->getDsSigla();
        $arrResult['bairro'] =$arrResult['bairro'];
        $arrResult['logradouro'] =$arrResult['logradouro'];
        $arrMunicipios = $this->getService('Application\Service\Municipio')->findBy(array('idEstado' => $arrEstado[0]->getIdEstado()));
        foreach ($arrMunicipios as $municipio) {
            $arrResult['idMunicipio'] = $municipio->getIdMunicipio();
            $arrResult['dsNome'] = $municipio->getDsNome();            
        }
        return $arrResult;       
    }

    private function getAdapter()
    {
        $strAdapter = $this->getService('config')['Adapter-CEP'];
        $adapter = new $strAdapter();
        return $adapter;
    }
}
