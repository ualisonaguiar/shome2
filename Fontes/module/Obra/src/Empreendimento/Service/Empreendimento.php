<?php

namespace Empreendimento\Service;

use CoreZend\Service\AbstractServiceRepository;

class Empreendimento extends AbstractServiceRepository
{
    use Message;

    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Empreendimento';
        $this->strPk = 'idEmpreendimento';
    }

    public function getListagem($arrDataPost)
    {

        die('sa');

    }
}
