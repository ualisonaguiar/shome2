<?php

namespace Empreendimento\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\Empreendimento as EmpreendimentoEntity;
use CoreZend\Util\Format;

class Empreendimento extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Empreendimento';
        $this->strPk = 'idEmpreendimento';
    }

    public function save($arrData)
    {
        try {
            if ($arrData['idEmpreendimento']) {
                $empreendimento = $this->find($arrData['idEmpreendimento']);
            } else {
                $empreendimento = new EmpreendimentoEntity();
            }
            $empreendimento->setCoCep(Format::clearMask($arrData['coCep']))
                ->setDsBairro($arrData['dsBairro'])
                ->setDsComplemento($arrData['dsComplemento'])
                ->setDsEmpreendimento($arrData['dsEmpreendimento'])
                ->setDsLogradouro($arrData['dsLogradouro'])
                ->setIdMunicipio($this->getReferenceEntity($arrData['coMunicipio'], 'Application\Entity\Municipio'))
                ->setInSituacao(EmpreendimentoEntity::co_situacao_ativo);
            $this->getEntityManager()->persist($empreendimento);
            $this->getEntityManager()->flush();            
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
    
    public function alterarSituacao($intIdEmpreendimento)
    {
        try {
            $empreendimento = $this->find($intIdEmpreendimento);
            if (!$empreendimento) {
                throw new \Exception('Empreendimento não localizado.');
            }
            if ($empreendimento->getInSituacao() == EmpreendimentoEntity::co_situacao_ativo) {
                $booStatus = false;
            } elseif ($empreendimento->getInSituacao() == EmpreendimentoEntity::co_situacao_inativo) {                
                $booStatus = true;
            }
            $empreendimento->setInSituacao($booStatus);
            $this->getEntityManager()->persist($empreendimento);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
