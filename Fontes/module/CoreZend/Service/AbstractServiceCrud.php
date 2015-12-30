<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreZend\Service;

use CoreZend\Service\AbstractServiceRepository;
use CoreZend\Entity\Configurator as ConfiguratorEntity;

/**
 * Description of AbstractServiceCrud
 *
 * @author ualison
 */
class AbstractServiceCrud extends AbstractServiceRepository
{
    protected $strPk        = '';
    protected $arrCondition = array();

    public function add($arrDadosPost)
    {
        $strNameEntity = $this->getNameEntity();
        $entity = ConfiguratorEntity::configure(
            (new $strNameEntity()),
            $arrDadosPost
        );
        return $this->salvar($entity);
    }

    public function edit($arrDadosPost)
    {
        return $this->salvar(
            ConfiguratorEntity::configure(
                $this->find($arrDadosPost[$this->strPk]),
                $arrDadosPost
            )
        );
    }

    public function delete($intPrimaryKey)
    {
        try {
            $entity = $this->find($intPrimaryKey);
            if (!$entity) {
                throw new \Exception('Registro não encontrado.');
            }
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function salvar($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
}
