<?php

namespace Authentication\Service;

use CoreZend\Service\AbstractServiceRepository;
use Zend\Authentication\Result;
use Authentication\Message\Message;
use Application\Entity\Login as LoginEtity;
use CoreZend\View\Helper\RenderTemplateTrait;
use Zend\Authentication\AuthenticationService;

class Authentication extends AbstractServiceRepository
{
    use Message,
        RenderTemplateTrait;

    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Login';
    }

    /**
     *
     * @param type $arrData
     * @return boolean
     * @throws \Exception
     */
    public function login($arrData)
    {
        try {
            /**
             * @documentacao https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md
             */
            $authService = $this->getService('Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($arrData['dsUsuario']);
            $adapter->setCredentialValue(md5($arrData['dsPassword']));
            $authResult = $authService->authenticate();
            if (!$authResult->isValid()) {
                throw new \Exception($this->getTypeErroAuthentication($authResult->getCode()));
            }
            $identity = $authResult->getIdentity();
            $arrDataSesion = (object) array(
                'pessoaFisica' => (object)  $identity->getIdPessoaFisica()->toArray()
            );
            $authenticationService = new AuthenticationService();
            $authenticationService->getStorage()->write($arrDataSesion);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     *
     * @param type $arrData
     * @return LoginEtity
     */
    public function save($arrData)
    {
        if (array_key_exists('idLogin', $arrData)) {
            $login = $this->find($arrData['idLogin']);
        } else {
            $login = new LoginEtity;
        }
        $pessoaFisica = $this->getReferenceEntity($arrData['idPessoaFisica'], 'Application\Entity\PessoaFisica');
        $login->setIdPessoaFisica($pessoaFisica)
            ->setDsLogin($arrData['dsLogin'])
            ->setDsPassword(md5($arrData['dsPassword']))
            ->setInAtivo(LoginEtity::CO_STATUS_ATIVO);
        $this->getEntityManager()->persist($login);
        $this->getEntityManager()->flush();
        return $login;
    }

    /**
     *
     * @param type $intCode
     * @return type
     */
    protected function getTypeErroAuthentication($intCode)
    {
        $strMessage = '';
        switch ($intCode) {
            case Result::FAILURE_IDENTITY_NOT_FOUND:
                $strMessage = $this->strMsgError03;
                break;
            case Result::FAILURE_CREDENTIAL_INVALID:
                $strMessage = $this->strMsgError04;
                break;
        }
        return $strMessage;
    }

    /**
     *
     * @param type $strUser
     * @param type $strPassword
     */
    public function getTextCadastroLogin($strNome, $strUser, $strPassword)
    {
        $arrVariables = array(
            'dsNome' => $strNome,
            'dsLogin' => $strUser,
            'dsPassoword' => $strPassword
        );
        return $this->renderTemplatePath('Security/view/template/cadastro-usuario-login.phtml', $arrVariables);
    }

    public function getTxReenvioSenha($strNome, $strUser, $strPassword)
    {
        $arrVariables = array(
            'dsNome' => $strNome,
            'dsLogin' => $strUser,
            'dsPassoword' => $strPassword
        );
        return $this->renderTemplatePath('Security/view/template/reenvio-senha.phtml', $arrVariables);
    }

    public function alterarSenha($intPessoaFisica, $strNovaSenha)
    {
        try {
            $this->begin();
            $arrLogin = $this->findBy(array('idPessoaFisica' => $intPessoaFisica));
            if (!$arrLogin) {
                throw new \Exception($this->strMsgError03);
            }
            $login = $arrLogin[0];
            $login->setDsPassword(md5($strNovaSenha));
            $this->getEntityManager()->persist($login);
            $this->getEntityManager()->flush();
            $this->commit();
            return $login;
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception->getMessage());
        }
    }
}
