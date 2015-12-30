<?php

namespace Perfil\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\Perfil as PerfilEntity;
use Perfil\Message\Message;

class Perfil extends AbstractServiceRepository
{
    use Message;

    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Perfil';
        $this->strPk = 'idPerfil';
    }

    public function save($arrDataPost)
    {
        try {
            $this->begin();
            $this->preSave($arrDataPost);
            $perfilEntity = (empty($arrDataPost[$this->strPk]))
                ? new PerfilEntity()
                : $this->find($arrDataPost[$this->strPk]);
            $perfilEntity->setDsPerfil($arrDataPost['dsPerfil'])
                ->setNoPerfil($arrDataPost['noPerfil'])
                ->setInAtivo(PerfilEntity::CO_STATUS_ATIVO);
            $this->getEntityManager()->persist($perfilEntity);
            $this->getEntityManager()->flush();
            $this->commit();
            return $perfilEntity;
        } catch (\Exception $exception) {
            $this->rollback();
            throw $exception;
        }
    }

    public function alterarSituacao($intIdPerfil)
    {
        try {
            $this->begin();
            $perfilEntity = $this->find($intIdPerfil);
            if (!$perfilEntity) {
                throw new \Exception('Perfil não localizado.');
            }
            $booInAtivo = ($perfilEntity->getInAtivo() == PerfilEntity::CO_STATUS_ATIVO)
                ? false
                : true;
            $perfilEntity->setInAtivo($booInAtivo);
            $this->getEntityManager()->persist($perfilEntity);
            $this->getEntityManager()->flush();
            $this->commit();
        } catch (\Exception $exception) {
            $this->rollback();
            throw $exception;
        }
    }

    protected function preSave($arrDataPost)
    {
        $perfil = $this->getRepositoryEntity()->findOneByNoPerfil($arrDataPost['noPerfil']);
        if ($perfil) {
            if ($perfil->getIdPerfil() != $arrDataPost['idPerfil']) {
                throw new \Exception($this->strMsgError01);
            }
        }
    }
}
