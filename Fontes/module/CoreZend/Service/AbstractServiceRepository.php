<?php

namespace CoreZend\Service;

use CoreZend\Service\AbstractServiceManager;

class AbstractServiceRepository extends AbstractServiceManager
{
    /**
     *
     * @var string
     */
    public $strNameEntity;

    /**
     * Objeto que representa o nome da entidade
     *
     * @var string
     */
    protected $entity;


    /**
     *
     * @var string
     */
    protected $strPk;

    /**
     *
     * @var type
     */
    private $entityManager;

    public function __construct($entityManager, $strClass)
    {
        $this->entityManager = $entityManager;
        $this->strNameEntity = $strClass;
        $this->entity = $this->getNameEntity();
    }

    public function find($intPkEntity)
    {
        try {
            $entityManager = $this->getEntityManager();
            return $entityManager->find($this->getNameEntity(), $intPkEntity);
        } catch (Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function findBy(array $arrCriteria = array(), array $arrOrderBy = null, $intLimit = null, $intOffset = null)
    {
        try {
            $entityManager = $this->getEntityManager();
            return $entityManager->getRepository($this->getNameEntity())->findBy(
                $arrCriteria,
                $arrOrderBy,
                $intLimit,
                $intOffset
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function fetchPairs(
        $strFieldCodigo,
        $strFieldValue,
        $arrCriteria = array(),
        array $arrOrderBy = null,
        $intLimit = null,
        $intOffset = null
    ) {
        try {
            $arrRegisterBd = $this->findBy($arrCriteria, $arrOrderBy, $intLimit, $intOffset);
            $arrRegister = array();
            foreach ($arrRegisterBd as $mixRegister) {
                $intKey = method_exists($mixRegister, $strFieldCodigo)
                    ? $mixRegister->$strFieldCodigo()
                    : $mixRegister[$strFieldCodigo];
                $strValue = method_exists($mixRegister, $strFieldValue)
                    ? $mixRegister->$strFieldValue()
                    : $mixRegister[$strFieldValue];
                $arrRegister[$intKey] = $strValue;
            }
            return $arrRegister;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function fetchPairsToXmlJson(
        $strFieldCodigo,
        $strFieldValue,
        $arrCriteria = array(),
        array $arrOrderBy = null,
        $intLimit = null,
        $intOffset = null
    ) {
        try {
            $arrRegisterBd = $this->findBy($arrCriteria, $arrOrderBy, $intLimit, $intOffset);
            $arrRegister = array();
            foreach ($arrRegisterBd as $intPosicao => $mixRegister) {
                $arrRegister[$intPosicao]['value'] = method_exists($mixRegister, $strFieldCodigo)
                    ? $mixRegister->$strFieldCodigo()
                    : $mixRegister[$strFieldCodigo];
                $arrRegister[$intPosicao]['text'] = method_exists($mixRegister, $strFieldValue)
                    ? $mixRegister->$strFieldValue()
                    : $mixRegister[$strFieldValue];
            }
            return $arrRegister;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function begin()
    {
        $this->getEntityManager()->getConnection()->beginTransaction();
    }

    public function commit()
    {
        $this->getEntityManager()->getConnection()->commit();
    }

    public function rollback()
    {
        $this->getEntityManager()->getConnection()->rollback();
    }

    public function getListagem($arrDataPost)
    {
        return $this->getRepositoryEntity()->getListagem($arrDataPost);
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function getRepositoryEntity($strEntity = null)
    {
        if (!$strEntity) {
            $strEntity = $this->getNameEntity();
        }
        return $this->getEntityManager()->getRepository($strEntity);
    }

    /**
     *
     * @return type
     */
    public function getNameEntity()
    {
        return str_replace('Service', 'Entity', $this->strNameEntity);
    }

    /**
     *
     * @param type $intId
     * @return type
     */
    public function delete($intId)
    {
        $entity = $this->getEntityManager()->getReference($this->entity, $intId);
        if ($entity) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
            return $entity;
        }
        return null;
    }

    /**
     *
     * @param chave primaria $intPkValue
     * @param nome da entidade $strEntity
     * @return type
     */
    public function getReferenceEntity($intPkValue, $strEntity = null)
    {
        if (empty($strEntity)) {
            $strEntity = $this->getNameEntity();
        }
        return ($strEntity) ? $this->getEntityManager()->getReference($strEntity, $intPkValue) : false;
    }

    public static function runPhpUnit()
    {
        if (strpos('phpunit', @$_SERVER['argv'][0]) !== true) {
            return true;
        }
        return false;
    }
}
