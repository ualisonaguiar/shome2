<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\TbMensageriaEmail
 *
 * @ORM\Table(name="tb_mensageria_email")
 * @ORM\Entity
 */
class MensageriaEmail
{
    /**
     * @var integer $idMensageriaEmail
     *
     * @ORM\Column(name="id_mensageria_email", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMensageriaEmail;

    /**
     * @var string $dsEmail
     *
     * @ORM\Column(name="ds_email", type="string", length=200, nullable=false)
     */
    private $dsEmail;

    /**
     * @var string $dsNome
     *
     * @ORM\Column(name="ds_nome", type="string", length=255, nullable=false)
     */
    private $dsNome;

    /**
     * @var string $dsTitle
     *
     * @ORM\Column(name="ds_title", type="string", length=200, nullable=false)
     */
    private $dsTitle;

    /**
     * @var text $dsTexto
     *
     * @ORM\Column(name="ds_texto", type="text", nullable=false)
     */
    private $dsTexto;

    /**
     * @var datetime $datEnvio
     *
     * @ORM\Column(name="dat_envio", type="datetime", nullable=true)
     */
    private $datEnvio;

    /**
     * @var datetime $datCadastro
     *
     * @ORM\Column(name="dat_cadastro", type="datetime", nullable=true)
     */
    private $datCadastro;

    /**
     * @var Application\Entity\ConfiguracaoEmail
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ConfiguracaoEmail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_configuracao_email", referencedColumnName="id_configuracao_email")
     * })
     */
    private $idConfiguracaoEmail;


    /**
     * Get idMensageriaEmail
     *
     * @return integer
     */
    public function getIdMensageriaEmail()
    {
        return $this->idMensageriaEmail;
    }

    /**
     * Set dsEmail
     *
     * @param string $dsEmail
     * @return TbMensageriaEmail
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
     * Set dsNome
     *
     * @param string $dsNome
     * @return TbMensageriaEmail
     */
    public function setDsNome($dsNome)
    {
        $this->dsNome = $dsNome;
        return $this;
    }

    /**
     * Get dsNome
     *
     * @return string
     */
    public function getDsNome()
    {
        return $this->dsNome;
    }

    /**
     * Set dsTitle
     *
     * @param string $dsTitle
     * @return TbMensageriaEmail
     */
    public function setDsTitle($dsTitle)
    {
        $this->dsTitle = $dsTitle;
        return $this;
    }

    /**
     * Get dsTitle
     *
     * @return string
     */
    public function getDsTitle()
    {
        return $this->dsTitle;
    }

    /**
     * Set dsTexto
     *
     * @param text $dsTexto
     * @return TbMensageriaEmail
     */
    public function setDsTexto($dsTexto)
    {
        $this->dsTexto = $dsTexto;
        return $this;
    }

    /**
     * Get dsTexto
     *
     * @return text
     */
    public function getDsTexto()
    {
        return $this->dsTexto;
    }

    /**
     * Set datEnvio
     *
     * @param datetime $datEnvio
     * @return TbMensageriaEmail
     */
    public function setDatEnvio($datEnvio)
    {
        $this->datEnvio = $datEnvio;
        return $this;
    }

    /**
     * Get datEnvio
     *
     * @return datetime
     */
    public function getDatEnvio()
    {
        if ($this->datEnvio) {
        return $this->datEnvio->format('d/m/Y');
    }
    }

    /**
     * Set datCadastro
     *
     * @param datetime $datCadastro
     * @return TbMensageriaEmail
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
        return $this->datCadastro->format('d/m/Y H:i:s');
    }

    /**
     * Set idConfiguracaoEmail
     *
     * @param Application\Entity\ConfiguracaoEmail $idConfiguracaoEmail
     * @return TbMensageriaEmail
     */
    public function setIdConfiguracaoEmail(\Application\Entity\ConfiguracaoEmail $idConfiguracaoEmail = null)
    {
        $this->idConfiguracaoEmail = $idConfiguracaoEmail;
        return $this;
    }

    /**
     * Get idConfiguracaoEmail
     *
     * @return Application\Entity\ConfiguracaoEmail
     */
    public function getIdConfiguracaoEmail()
    {
        return $this->idConfiguracaoEmail;
    }
}
