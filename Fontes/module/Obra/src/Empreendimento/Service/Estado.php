<?php

namespace Empreendimento\Service;

use CoreZend\Service\AbstractServiceRepository;

class Estado extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Estado';
        $this->strPk = 'idEstado';
    }
}
