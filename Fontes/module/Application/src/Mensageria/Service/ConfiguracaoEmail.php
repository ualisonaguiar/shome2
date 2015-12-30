<?php

namespace Mensageria\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\ConfiguracaoEmail as ConfiguracaoEmailEntity;

class ConfiguracaoEmail extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\ConfiguracaoEmail';
        $this->strPk = 'idConfiguracaoEmail';
    }

    public function save($arrData)
    {
        try {
            if (!array_key_exists('inAtivo', $arrData)) {
                $arrData['inAtivo'] = ConfiguracaoEmailEntity::CO_STATUS_ATIVO;
            }
            $configuracaoEntity = new ConfiguracaoEmailEntity();
            $configuracaoEntity->setDsComplemento($arrData['dsComplemento'])
                ->setDsEmail($arrData['dsEmail'])
                ->setDsPassword($arrData['dsPassword'])
                ->setDsSmtp($arrData['dsSmtp'])
                ->setDsUsuario($arrData['dsUsuario'])
                ->setInAtivo($arrData['inAtivo']);
            $this->getEntityManager()->persist($configuracaoEntity);
            $this->getEntityManager()->flush();
            return $configuracaoEntity;
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }
}
