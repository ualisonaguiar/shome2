<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\ConfiguracaoEmail
 *
 * @ORM\Table(name="tb_configuracao_email")
 * @ORM\Entity
 */
class ConfiguracaoEmail
{
    const CO_STATUS_ATIVO = 1;

    const CO_STATUS_INATIVO = 0;

    /**
     * @var integer $idConfiguracaoEmail
     *
     * @ORM\Column(name="id_configuracao_email", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfiguracaoEmail;

    /**
     * @var string $dsSmtp
     *
     * @ORM\Column(name="ds_smtp", type="string", length=255, nullable=false)
     */
    private $dsSmtp;

    /**
     * @var string $dsUsuario
     *
     * @ORM\Column(name="ds_usuario", type="string", length=255, nullable=false)
     */
    private $dsUsuario;

    /**
     * @var string $dsEmail
     *
     * @ORM\Column(name="ds_email", type="string", length=150, nullable=false)
     */
    private $dsEmail;

    /**
     * @var string $dsPassword
     *
     * @ORM\Column(name="ds_password", type="string", length=100, nullable=false)
     */
    private $dsPassword;

    /**
     * @var text $dsComplemento
     *
     * @ORM\Column(name="ds_complemento", type="text", nullable=true)
     */
    private $dsComplemento;

    /**
     * @var boolean $inAtivo
     *
     * @ORM\Column(name="in_ativo", type="boolean", nullable=true)
     */
    private $inAtivo;

    /**
     * @var datetime $datCadastro
     *
     * @ORM\Column(name="dat_cadastro", type="datetime", nullable=true)
     */
    private $datCadastro;


    /**
     * Get idConfiguracaoEmail
     *
     * @return integer
     */
    public function getIdConfiguracaoEmail()
    {
        return $this->idConfiguracaoEmail;
    }

    /**
     * Set dsSmtp
     *
     * @param string $dsSmtp
     * @return TbConfiguracaoEmail
     */
    public function setDsSmtp($dsSmtp)
    {
        $this->dsSmtp = $dsSmtp;
        return $this;
    }

    /**
     * Get dsSmtp
     *
     * @return string
     */
    public function getDsSmtp()
    {
        return $this->dsSmtp;
    }

    /**
     * Set dsUsuario
     *
     * @param string $dsUsuario
     * @return TbConfiguracaoEmail
     */
    public function setDsUsuario($dsUsuario)
    {
        $this->dsUsuario = $dsUsuario;
        return $this;
    }

    /**
     * Get dsUsuario
     *
     * @return string
     */
    public function getDsUsuario()
    {
        return $this->dsUsuario;
    }

    /**
     * Set dsEmail
     *
     * @param string $dsEmail
     * @return TbConfiguracaoEmail
     */
    public function setDsEmail($dsEmail)
    {
        $this->dsEmail = $dsEmail;
        return $this;
    }

    /**
     * Get dsEmail
     *
     * @return string
     */
    public function getDsEmail()
    {
        return $this->dsEmail;
    }

    /**
     * Set dsPassword
     *
     * @param string $dsPassword
     * @return TbConfiguracaoEmail
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
     * Set dsComplemento
     *
     * @param text $dsComplemento
     * @return TbConfiguracaoEmail
     */
    public function setDsComplemento($dsComplemento)
    {
        $this->dsComplemento = $dsComplemento;
        return $this;
    }

    /**
     * Get dsComplemento
     *
     * @return text
     */
    public function getDsComplemento()
    {
        return $this->dsComplemento;
    }

    /**
     * Set inAtivo
     *
     * @param boolean $inAtivo
     * @return TbConfiguracaoEmail
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
        return $this->inAtivo == self::CO_STATUS_ATIVO;
    }

    /**
     * Set datCadastro
     *
     * @param datetime $datCadastro
     * @return TbConfiguracaoEmail
     */
    public function setDatCadastro($datCadastro)
    {
        $this->datCadastro = $datCadastro;
        return $this;
    }

    /**
     * Get datCadastro
     *
     * @return datetime
     */
    public function getDatCadastro()
    {
        return $this->datCadastro;
    }
}
