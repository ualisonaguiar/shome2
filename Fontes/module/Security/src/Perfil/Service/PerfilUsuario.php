<?php

namespace Perfil\Service;

use CoreZend\Service\AbstractServiceCrud;
use Application\Entity\Login as LoginEntity;

class PerfilUsuario extends AbstractServiceCrud
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Perfil';
        $this->strPk = 'idPerfil';
    }

    public function getListagemLoginNaoVinculado($intIdPerfil)
    {
        //return $this->getRepositoryEntity()->getListagemLoginNaoVinculado($intIdPerfil);
        $arrLogin = $this->getService('Authentication\Service\Authentication')
            ->findBy(array(), array('dsLogin' => 'asc'));
        $perfilLogin = $this->find($intIdPerfil);
        $arrLoginPerfil = array();
        $arrLoginNotPerfil = array();
        foreach ($perfilLogin->getIdLogin() as $perfil) {
            $arrLoginPerfil[$perfil->getIdLogin()] = $perfil->getDsLogin();
        }
        foreach ($arrLogin as $intPosicao => $login) {
            if (array_key_exists($login->getIdLogin(), $arrLoginPerfil)) {
                unset($arrLogin[$intPosicao]);
            } else {
                $arrLoginNotPerfil[$login->getIdLogin()] = $login->getDsLogin();
            }
        }
        return $arrLoginNotPerfil;
    }

    public function save($arrData)
    {
        try {
            $this->begin();
            $this->preSave($arrData);
            $login = $this->getReferenceEntity($arrData['idLogin'], 'Application\Entity\Login');
            $perfilEntity = $this->find($arrData['idPerfil']);
            $perfilEntity->addLogin($login);
            $this->getEntityManager()->persist($perfilEntity);
            $this->getEntityManager()->flush();
            $this->commit();
            return array(
                'noPessoaFisica' => $login->getIdPessoaFisica()->getDsNome(),
                'noLogin' => $login->getDsLogin(),
                'inSituacao' => LoginEntity::$arrSituacao[$login->getInAtivo()],
                'idLogin' => $arrData['idLogin']
            );
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception->getMessage());
        }
    }

    public function remove($arrData)
    {
        try {
            $this->begin();
            $perfilEntity = $this->find($arrData['idPerfil']);
            $login = $this->getReferenceEntity($arrData['idLogin'], 'Application\Entity\Login');
            $perfilEntity->removeLogin($login);
            $this->getEntityManager()->persist($perfilEntity);
            $this->getEntityManager()->flush();
            $this->commit();
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception->getMessage());
        }
    }

    protected function preSave($arrData)
    {
        # @TODO melhorar este metodo implementando o contains.
        $arrPerfil = $this->find($arrData['idPerfil']);
        $arrLogin = $arrPerfil->getIdLogin();
        foreach ($arrLogin as $login) {
            if ($login->getIdLogin() == $arrData['idLogin']) {
                throw new \Exception('Este perfil encontra-se vinculado a este usuário.');
            }
        }
    }
}
