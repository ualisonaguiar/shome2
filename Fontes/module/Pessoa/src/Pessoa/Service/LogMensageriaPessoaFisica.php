<?php

namespace Pessoa\Service;

use CoreZend\Service\AbstractServiceRepository;

class LogMensageriaPessoaFisica extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\LogMensageriaPessoaFisica';
    }
}
