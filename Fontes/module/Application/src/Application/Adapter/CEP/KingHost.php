<?php

namespace Application\Adapter\CEP;

use Zend\Http\Client;

class KingHost implements InterfacePesquisaCep
{
    private $auth = 'b14a7b8059d9c055954c92674ce60032';

    public function pesquisaCep($strCEP)
    {
        $httpClient = new Client();
        $httpClient->setUri('http://webservice.kinghost.net/web_cep.php')
            ->setParameterGet(
                array(
                    'auth' => $this->auth,
                    'formato' => 'json',
                    'cep' => $strCEP
                )
            );
        $response = (object) json_decode($httpClient->send()->getBody(),true);
        return array(
            'uf' => $response->uf,
            'cidade' => $response->cidade,
            'bairro' => $response->bairro,
            'logradouro' => $response->logradouro,
            'status' => ($response->resultado) ? true : false,
            'message' => (!$response->resultado) ? 'CEP não encontrado' : ''
        );
    }
}
