<?php

namespace Application\Service;

use CoreZend\Service\AbstractServiceRepository;

class Municipio extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Municipio';
        $this->strPk = 'idMunicipio';
    }
}
