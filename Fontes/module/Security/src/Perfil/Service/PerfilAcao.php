<?php

namespace Perfil\Service;

use CoreZend\Service\AbstractServiceCrud;

class PerfilAcao extends AbstractServiceCrud
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\Perfil';
        $this->strPk = 'idPerfil';
    }

    public function getListagemAcaoNaoVinculado($intIdPerfil)
    {
        $arrAcao = $this->getService('Acao\Service\Acao')->findBy(array('inAtivo' => true));
        $arrAcaoSelect = array();
        $perfilLogin = $this->find($intIdPerfil);
        foreach ($arrAcao as $acao) {
            if (!$acao->getDsAction() || $perfilLogin->getIdAcao()->contains($acao) === true) {
                continue;
            }
            $strLabel = '';
            if ($acao->getIdAcaoSuperior()) {
                if ($acao->getIdAcaoSuperior()->getIdAcaoSuperior()) {
                    $strLabel = $acao->getIdAcaoSuperior()->getIdAcaoSuperior()->getDsLabel() . ' / ';
                }
                $strLabel .= $acao->getIdAcaoSuperior()->getDsLabel() . ' / ';
            }
            $strLabel .= $acao->getDsLabel();
            $strGroup = ($acao->getInVisible()) ? 'Menu' : 'Funcionalidade';
            $arrOptions = array($acao->getIdAcao() => $strLabel);
            if (array_key_exists($strGroup, $arrAcaoSelect)) {
                $arrOptions += $arrAcaoSelect[$strGroup]['options'];
            }

            $arrAcaoSelect[$strGroup] = array('label' => $strGroup, 'options' => $arrOptions);
        }
        ksort($arrAcaoSelect);
        return $arrAcaoSelect;
    }

    public function save($arrData)
    {
        try {
            $this->begin();
            $acao = $this->getReferenceEntity($arrData['idAcao'], 'Application\Entity\Acao');
            $perfilEntity = $this->find($arrData['idPerfil']);
            $this->preSave($acao, $perfilEntity);
            $perfilEntity->addAcao($acao);
            $this->getEntityManager()->persist($perfilEntity);
            $this->getEntityManager()->flush();
            $this->commit();
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception->getMessage());
        }
    }

    public function remove($arrData)
    {
        try {
            $this->begin();
            $perfilEntity = $this->find($arrData['idPerfil']);
            $acao = $this->getReferenceEntity($arrData['idAcao'], 'Application\Entity\Acao');
            $perfilEntity->removeAcao($acao);
            $this->getEntityManager()->persist($perfilEntity);
            $this->getEntityManager()->flush();
            $this->commit();
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception->getMessage());
        }
    }

    protected function preSave($acao, $perfil)
    {
        if ($perfil->getIdLogin()->contains($acao) === true) {
            throw new \Exception('Este perfil encontra-se vinculado a esta ação.');
        }

    }
}
