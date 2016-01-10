<?php

namespace Application\Adapter\CEP;

use Zend\Http\Client;

class CorreioControl implements InterfacePesquisaCep
{
    public function pesquisaCep($strCEP)
    {
        try {
            $httpClient = new Client();
            $httpClient->setUri('http://cep.correiocontrol.com.br/' . $strCEP . '.json');
            $strResponseBody = $httpClient->send()->getBody();
            if (!$strResponseBody) {
                return array('status' => false, 'message' => 'CEP não encontrado');
            }
            $response = (object) json_decode($strResponseBody, true);
            return array(
                'uf' => $response->uf,
                'cidade' => $response->localidade,
                'bairro' => $response->bairro,
                'logradouro' => $response->logradouro,
                'status' => true,
                'message' => ''
            );
        } catch (\Exception $exception) {
            return array('status' => false, 'message' => 'Não foi possível estabelcer conexão ao site dos correios.');
        }      
    }

}
