<?php

namespace Empreendimento\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\Empreendimento as EmpreendimentoEntity;

class Empreendimento extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Empreendimento';
        $this->strPk = 'idEmpreendimento';
    }

    public function save()
    {
        $empreendimento = new EmpreendimentoEntity();
        $empreendimento->setCoCep('73350303')
            ->setDsBairro('Planaltina')
            ->setDsComplemento('32A')
            ->setDsEmpreendimento('Casa da Estância')
            ->setDsLogradouro('Quadra 03 Conjunto C')
            ->setIdMunicipio(530021)
            ->setInSituacao(1);
        $this->getEntityManager()->persist($empreendimento);
        $this->getEntityManager()->flush();
    }
}
