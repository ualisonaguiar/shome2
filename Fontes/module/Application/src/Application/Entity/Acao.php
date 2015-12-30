<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Application\Entity\Acao
 *
 * @ORM\Table(name="tb_acao")
 * @ORM\Entity
 */
class Acao
{
    const SITUACAO_VISIVEL = 1;
    const SITUACAO_NAO_VISIVEL = 0;
    const CO_STATUS_ATIVO = 1;
    const CO_STATUS_INATIVO = 0;

    static $arrApresentacaoMenu = array(
        self::SITUACAO_VISIVEL => 'Vísivel',
        self::SITUACAO_NAO_VISIVEL => 'Não vísivel'
    );

    static $arrSituacao = array(
        self::CO_STATUS_ATIVO => 'Ativo',
        self::CO_STATUS_INATIVO => 'Inativo'
    );

    /**
     * @var integer $idAcao
     *
     * @ORM\Column(name="id_acao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAcao;

    /**
     * @var Application\Entity\Acao
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Acao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_acao_superior", referencedColumnName="id_acao")
     * })
     */
    private $idAcaoSuperior;

    /**
     * @var string $dsLabel
     *
     * @ORM\Column(name="ds_label", type="string", length=250, nullable=false)
     */
    private $dsLabel;

    /**
     * @var string $dsRoute
     *
     * @ORM\Column(name="ds_route", type="string", length=100, nullable=false)
     */
    private $dsRoute;

    /**
     * @var string $dsAction
     *
     * @ORM\Column(name="ds_action", type="string", length=100, nullable=true)
     */
    private $dsAction;

    /**
     * @var boolean $inVisiable
     *
     * @ORM\Column(name="in_visible", type="boolean", nullable=false)
     */
    private $inVisible;

    /**
     * @var boolean $inAtivo
     *
     * @ORM\Column(name="in_ativo", type="boolean", nullable=false)
     */
    private $inAtivo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Perfil", mappedBy="idAcao")
     */
    private $idPerfil;

    public function __construct()
    {
        $this->idPerfil = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idAcao
     *
     * @return integer
     */
    public function getIdAcao()
    {
        return $this->idAcao;
    }

    /**
     * Set idAcao
     *
     * @param integer $idAcao
     * @return Acao
     */
    public function setIdAcao($idAcao)
    {
        $this->idAcao = $idAcao;
        return $this;
    }

    /**
     * Set idAcaoSuperior
     *
     * @param integer $idAcaoSuperior
     * @return Acao
     */
    public function setIdAcaoSuperior(\Application\Entity\Acao $idAcaoSuperior)
    {
        $this->idAcaoSuperior = $idAcaoSuperior;
        return $this;
    }

    /**
     * Get idAcaoSuperior
     *
     * @return integer
     */
    public function getIdAcaoSuperior()
    {
        return $this->idAcaoSuperior;
    }

    /**
     * Set dsLabel
     *
     * @param string $dsLabel
     * @return Acao
     */
    public function setDsLabel($dsLabel)
    {
        $this->dsLabel = $dsLabel;
        return $this;
    }

    /**
     * Get dsLabel
     *
     * @return string
     */
    public function getDsLabel()
    {
        return $this->dsLabel;
    }

    /**
     * Set dsRoute
     *
     * @param string $dsRoute
     * @return Acao
     */
    public function setDsRoute($dsRoute)
    {
        $this->dsRoute = $dsRoute;
        return $this;
    }

    /**
     * Get dsRoute
     *
     * @return string
     */
    public function getDsRoute()
    {
        return $this->dsRoute;
    }

    /**
     * Set dsAction
     *
     * @param string $dsAction
     * @return Acao
     */
    public function setDsAction($dsAction)
    {
        $this->dsAction = $dsAction;
        return $this;
    }

    /**
     * Get dsAction
     *
     * @return string
     */
    public function getDsAction()
    {
        return $this->dsAction;
    }

    /**
     * Set inVisible
     *
     * @param boolean $inVisible
     * @return Acao
     */
    public function setInVisible($inVisible)
    {
        $this->inVisible = $inVisible;
        return $this;
    }

    /**
     * Get inVisible
     *
     * @return boolean
     */
    public function getInVisible()
    {
        return $this->inVisible;
    }

    /**
     * Set inAtivo
     *
     * @param boolean $inAtivo
     * @return Acao
     */
    public function setInAtivo($inAtivo)
    {
        $this->inAtivo = $inAtivo;
        return $this;
    }

    /**
     * Get inAtivo
     *
     * @return boolean
     */
    public function getInAtivo()
    {
        return $this->inAtivo;
    }


    /**
     * Add perfil
     *
     * @param Application\Entity\Perfil $perfil
     */
    public function addPerfil(\Application\Entity\Perfil $perfil)
    {
        if (true === $this->idPerfil->contains($perfil)) {
            return;
        }
        $this->idPerfil->add($perfil);
        $perfil->addAcao($this);
    }

    /**
     * Remove perfil
     *
     * @param Application\Entity\Perfil $perfil
     */
    public function removePerfil(\Application\Entity\Perfil $perfil)
    {
        if (false === $this->idPerfil->contains($perfil)) {
            return;
        }
        $this->idPerfil->removeElement($perfil);
        $perfil->removeAcao($this);
    }

    /**
     * Get idPerfil
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     *
     * @return type
     */
    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->setUnderscoreSeparatedKeys(false);
        return $hydrator->extract($this);
    }
}