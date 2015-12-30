<?php

namespace Acao\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\Acao as AcaoEntity;

class Acao extends AbstractServiceRepository
{

    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Acao';
        $this->strPk = 'idAcao';
    }

    public function save($arrDataPost)
    {
        try {
            $this->begin();
            $acaoEntity = (empty($arrDataPost[$this->strPk]))
                ? new AcaoEntity()
                : $this->find($arrDataPost[$this->strPk]);
            $acaoEntity->setDsAction($arrDataPost['dsAction'])
                ->setDsLabel($arrDataPost['dsLabel'])
                ->setDsRoute($arrDataPost['dsRoute'])
                ->setInAtivo($arrDataPost['inAtivo'])
                ->setInVisible($arrDataPost['inVisible']);
            $this->getEntityManager()->persist($acaoEntity);
            $this->getEntityManager()->flush();
            $this->commit();
        } catch (\Exception $exception) {
            $this->rollback();
            throw $exception;
        }
    }
}
