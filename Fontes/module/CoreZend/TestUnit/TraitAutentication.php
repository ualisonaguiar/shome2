<?php

namespace CoreZend\TestUnit;

use FinancasTest\Bootstrap;
use CoreZend\Util\String;

trait TraitAutentication
{
    public function makeLogin()
    {
        $strLogin = 'login_php@testunitario';
        $strSenha = 'abcd1234';
        $serviceManager = Bootstrap::getServiceManager();
        $serviceAuthentication = $serviceManager->get('Authentication\Service\Authentication');
        if (!$serviceAuthentication->findBy(array('dsLogin' => $strLogin))) {
            $this->insertLogin($strLogin, $strSenha);
        }
        $serviceAuthentication = $serviceManager->get('Authentication\Service\Authentication');
        $serviceAuthentication->login(
            array(
                'dsUsuario' => $strLogin,
                'dsPassword' => $strSenha
            )
        );
    }

    protected function insertLogin($strLogin, $strNovaSenha)
    {
        $serviceManager = Bootstrap::getServiceManager();
        $serviceConfiguracaoEmail = $serviceManager->get('Mensageria\Service\ConfiguracaoEmail');
        $serviceConfiguracaoEmail->save(
            array(
                'dsComplemento' => String::generateRandomExpression(5),
                'dsEmail' => String::generateRandomExpression(5),
                'dsPassword' => String::generateRandomExpression(5),
                'dsSmtp' => String::generateRandomExpression(5),
                'dsUsuario' => String::generateRandomExpression(5),
            )
        );
        $arrDataPessoa = array(
            'dsEmail' => $strLogin,
            'dsNome' => $strLogin,
            'dsCpf' => '11111111111',
            'datAniversario' => date('d/m/Y'),
            'dsLogin' => $strLogin,
            'idPessoaFisica' => null
        );
        $pessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica')
            ->save($arrDataPessoa);
        $serviceManager->get('Authentication\Service\Authentication')
            ->alterarSenha(
                $pessoaFisica->getIdPessoaFisica(),
                $strNovaSenha
            );
    }
}
