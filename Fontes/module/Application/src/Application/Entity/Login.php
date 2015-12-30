<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Application\Entity\Login
 *
 * @ORM\Table(name="tb_login")
 * @ORM\Entity
 */
class Login
{
    const CO_STATUS_ATIVO = 1;

    const CO_STATUS_INATIVO = 0;

    public static $arrSituacao = array(
        self::CO_STATUS_ATIVO => 'Ativo',
        self::CO_STATUS_INATIVO => 'Inativo'
    );

    /**
     * @var integer $idLogin
     *
     * @ORM\Column(name="id_login", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLogin;

    /**
     * @var string $dsLogin
     *
     * @ORM\Column(name="ds_login", type="string", length=100, nullable=false)
     */
    private $dsLogin;

    /**
     * @var string $dsPassword
     *
     * @ORM\Column(name="ds_password", type="string", length=50, nullable=false)
     */
    private $dsPassword;

    /**
     * @var boolean $inAtivo
     *
     * @ORM\Column(name="in_ativo", type="boolean", nullable=true)
     */
    private $inAtivo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Perfil", inversedBy="idLogin")
     * @ORM\JoinTable(name="tb_login_perfil",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_login", referencedColumnName="id_login")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     *   }
     * )
     */
    private $idPerfil;

    /**
     * @var Application\Entity\PessoaFisica
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\PessoaFisica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa_fisica", referencedColumnName="id_pessoa_fisica")
     * })
     */
    private $idPessoaFisica;


    public function __construct()
    {
        $this->idPerfil = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idLogin
     *
     * @return integer
     */
    public function getIdLogin()
    {
        return $this->idLogin;
    }

    /**
     * Set dsLogin
     *
     * @param string $dsLogin
     * @return TbLogin
     */
    public function setDsLogin($dsLogin)
    {
        $this->dsLogin = $dsLogin;
        return $this;
    }

    /**
     * Get dsLogin
     *
     * @return string
     */
    public function getDsLogin()
    {
        return $this->dsLogin;
    }

    /**
     * Set dsPassword
     *
     * @param string $dsPassword
     * @return TbLogin
     */
    public function setDsPassword($dsPassword)
    {
        $this->dsPassword = $dsPassword;
        return $this;
    }

    /**
     * Get dsPassword
     *
     * @return string
     */
    public function getDsPassword()
    {
        return $this->dsPassword;
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
     * Set idPessoaFisica
     *
     * @param Application\Entity\PessoaFisica $idPessoaFisica
     * @return TbLogin
     */
    public function setIdPessoaFisica(\Application\Entity\PessoaFisica $idPessoaFisica = null)
    {
        $this->idPessoaFisica = $idPessoaFisica;
        return $this;
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
        $perfil->addLogin($this);
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
        $perfil->removeLogin($this);
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
     * Get idPessoaFisica
     *
     * @return Application\Entity\TbPessoaFisica
     */
    public function getIdPessoaFisica()
    {
        return $this->idPessoaFisica;
    }

    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->setUnderscoreSeparatedKeys(false);
        return $hydrator->extract($this);
    }
}
