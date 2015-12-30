<?php

namespace Mensageria\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\ConfiguracaoEmail as ConfiguracaoEmailEntity;
use Application\Entity\MensageriaEmail as MensageriaEmailEntity;

class MensageriaEmail extends AbstractServiceRepository
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\MensageriaEmail';
        $this->strPk = 'idMensageriaEmail';
    }

    public function registrarEnvio($strDsEmail, $strDsNome = null, $strTitle = null, $strTexto = null)
    {
        try {
            $arrConfiguracaoEmail = $this->getService('Mensageria\Service\ConfiguracaoEmail')->findBy(
                array(
                    'inAtivo' => ConfiguracaoEmailEntity::CO_STATUS_ATIVO
                )
            );
            if (!$arrConfiguracaoEmail) {
                throw new \Exception('Não existe configuração registrada no envio de e-mail');
            }
            $mensageriaEmail = new MensageriaEmailEntity();
            $mensageriaEmail->setDsEmail($strDsEmail)
                ->setDsNome($strDsNome)
                ->setDsTexto($strTexto)
                ->setDsTitle($strTitle)
                ->setIdConfiguracaoEmail(reset($arrConfiguracaoEmail))
                ->setDatCadastro(new \DateTime('now'));
            $this->getEntityManager()->persist($mensageriaEmail);
            $this->getEntityManager()->flush();
            return $mensageriaEmail;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
