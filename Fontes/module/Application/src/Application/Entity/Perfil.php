<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Application\Entity\Perfil
 *
 * @ORM\Table(name="tb_perfil")
 * @ORM\Entity(repositoryClass="Perfil\Entity\PerfilRepository")
 */
class Perfil
{
    const CO_STATUS_ATIVO = 1;

    const CO_STATUS_INATIVO = 0;

    static $arrSituacao = array(
        self::CO_STATUS_ATIVO => 'Ativo',
        self::CO_STATUS_INATIVO => 'Inativo'
    );

    /**
     * @var integer $idPerfil
     *
     * @ORM\Column(name="id_perfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerfil;

    /**
     * @var string $noPerfil
     *
     * @ORM\Column(name="no_perfil", type="string", length=255, nullable=false)
     */
    private $noPerfil;

    /**
     * @var string $dsPerfil
     *
     * @ORM\Column(name="ds_perfil", type="string", length=4000, nullable=true)
     */
    private $dsPerfil;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Login", mappedBy="idPerfil")
     */
    private $idLogin;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Acao", inversedBy="idPerfil")
     * @ORM\JoinTable(name="tb_perfil_acao",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_acao", referencedColumnName="id_acao")
     *   }
     * )
     */
    private $idAcao;

    /**
     * @var boolean $inAtivo
     *
     * @ORM\Column(name="in_ativo", type="boolean", nullable=true)
     */
    private $inAtivo;

    public function __construct()
    {
        $this->idLogin = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idPerfil
     *
     * @return integer
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * Set noPerfil
     *
     * @param string $noPerfil
     * @return TbPerfil
     */
    public function setNoPerfil($noPerfil)
    {
        $this->noPerfil = $noPerfil;
        return $this;
    }

    /**
     * Get noPerfil
     *
     * @return string
     */
    public function getNoPerfil()
    {
        return $this->noPerfil;
    }

    /**
     * Set dsPerfil
     *
     * @param string $dsPerfil
     * @return TbPerfil
     */
    public function setDsPerfil($dsPerfil)
    {
        $this->dsPerfil = $dsPerfil;
        return $this;
    }

    /**
     * Get dsPerfil
     *
     * @return string
     */
    public function getDsPerfil()
    {
        return $this->dsPerfil;
    }

    /**
     * Add login
     *
     * @param Application\Entity\Login $login
     */
    public function addLogin(\Application\Entity\Login $login)
    {
        if (true === $this->idLogin->contains($login)) {
            return;
        }
        $this->idLogin->add($login);
        $login->addPerfil($this);
    }

    /**
     * Remove login
     *
     * @param Application\Entity\Login $login
     */
    public function removeLogin(\Application\Entity\Login $login)
    {
        if (false === $this->idLogin->contains($login)) {
            return;
        }
        $this->idLogin->removeElement($login);
        $login->removePerfil($this);
    }

    /**
     * Get idLogin
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getIdLogin()
    {
        return $this->idLogin;
    }

    /**
     * Set inAtivo
     *
     * @param boolean $inAtivo
     * @return TbLogin
     */
    public function setInAtivo($inAtivo)
    {
        $this->inAtivo = $inAtivo;
        return $this;
    }

    /**
     * Get inAtivo
     *
     * @return integer
     */
    public function getInAtivo()
    {
        return $this->inAtivo;
    }

    /**
     * Add acao
     *
     * @param Application\Entity\Acao $acao
     */
    public function addAcao(\Application\Entity\Acao $acao)
    {
        if (true === $this->idAcao->contains($acao)) {
            return;
        }
        $this->idAcao->add($acao);
        $acao->addPerfil($this);
    }

    /**
     * Remove acao
     *
     * @param Application\Entity\Acao $acao
     */
    public function removeAcao(\Application\Entity\Acao $acao)
    {
        if (false === $this->idAcao->contains($acao)) {
            return;
        }
        $this->idAcao->removeElement($acao);
        $acao->removePerfil($this);
    }

    /**
     * Get idAcao
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getIdAcao()
    {
        return $this->idAcao;
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