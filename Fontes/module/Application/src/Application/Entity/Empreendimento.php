<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\Empreendimento
 *
 * @ORM\Table(name="tb_empreendimento")
 * @ORM\Entity
 */
class Empreendimento
{
    /**
     * @var integer $idEmpreendimento
     *
     * @ORM\Column(name="id_empreendimento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmpreendimento;

    /**
     * @var integer $idMunicipio
     *
     * @ORM\Column(name="id_municipio", type="integer", nullable=false)
     */
    private $idMunicipio;

    /**
     * @var string $dsEmpreendimento
     *
     * @ORM\Column(name="ds_empreendimento", type="string", length=255, nullable=false)
     */
    private $dsEmpreendimento;

    /**
     * @var string $dsLogradouro
     *
     * @ORM\Column(name="ds_logradouro", type="string", length=4000, nullable=false)
     */
    private $dsLogradouro;

    /**
     * @var string $dsBairro
     *
     * @ORM\Column(name="ds_bairro", type="string", length=1000, nullable=false)
     */
    private $dsBairro;

    /**
     * @var string $dsComplemento
     *
     * @ORM\Column(name="ds_complemento", type="string", length=200, nullable=false)
     */
    private $dsComplemento;

    /**
     * @var string $coCep
     *
     * @ORM\Column(name="co_cep", type="string", length=8, nullable=false)
     */
    private $coCep;

    /**
     * @var boolean $inSituacao
     *
     * @ORM\Column(name="in_situacao", type="boolean", nullable=false)
     */
    private $inSituacao;

    /**
     * @var text $dsObservacao
     *
     * @ORM\Column(name="ds_observacao", type="text", nullable=true)
     */
    private $dsObservacao;


    /**
     * Get idEmpreendimento
     *
     * @return integer 
     */
    public function getIdEmpreendimento()
    {
        return $this->idEmpreendimento;
    }

    /**
     * Set idMunicipio
     *
     * @param integer $idMunicipio
     * @return TbEmpreendimento
     */
    public function setIdMunicipio($idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
        return $this;
    }

    /**
     * Get idMunicipio
     *
     * @return integer 
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }

    /**
     * Set dsEmpreendimento
     *
     * @param string $dsEmpreendimento
     * @return TbEmpreendimento
     */
    public function setDsEmpreendimento($dsEmpreendimento)
    {
        $this->dsEmpreendimento = $dsEmpreendimento;
        return $this;
    }

    /**
     * Get dsEmpreendimento
     *
     * @return string 
     */
    public function getDsEmpreendimento()
    {
        return $this->dsEmpreendimento;
    }

    /**
     * Set dsLogradouro
     *
     * @param string $dsLogradouro
     * @return TbEmpreendimento
     */
    public function setDsLogradouro($dsLogradouro)
    {
        $this->dsLogradouro = $dsLogradouro;
        return $this;
    }

    /**
     * Get dsLogradouro
     *
     * @return string 
     */
    public function getDsLogradouro()
    {
        return $this->dsLogradouro;
    }

    /**
     * Set dsBairro
     *
     * @param string $dsBairro
     * @return TbEmpreendimento
     */
    public function setDsBairro($dsBairro)
    {
        $this->dsBairro = $dsBairro;
        return $this;
    }

    /**
     * Get dsBairro
     *
     * @return string 
     */
    public function getDsBairro()
    {
        return $this->dsBairro;
    }

    /**
     * Set dsComplemento
     *
     * @param string $dsComplemento
     * @return TbEmpreendimento
     */
    public function setDsComplemento($dsComplemento)
    {
        $this->dsComplemento = $dsComplemento;
        return $this;
    }

    /**
     * Get dsComplemento
     *
     * @return string 
     */
    public function getDsComplemento()
    {
        return $this->dsComplemento;
    }

    /**
     * Set coCep
     *
     * @param string $coCep
     * @return TbEmpreendimento
     */
    public function setCoCep($coCep)
    {
        $this->coCep = $coCep;
        return $this;
    }

    /**
     * Get coCep
     *
     * @return string 
     */
    public function getCoCep()
    {
        return $this->coCep;
    }

    /**
     * Set inSituacao
     *
     * @param boolean $inSituacao
     * @return TbEmpreendimento
     */
    public function setInSituacao($inSituacao)
    {
        $this->inSituacao = $inSituacao;
        return $this;
    }

    /**
     * Get inSituacao
     *
     * @return boolean 
     */
    public function getInSituacao()
    {
        return $this->inSituacao;
    }

    /**
     * Set dsObservacao
     *
     * @param text $dsObservacao
     * @return TbEmpreendimento
     */
    public function setDsObservacao($dsObservacao)
    {
        $this->dsObservacao = $dsObservacao;
        return $this;
    }

    /**
     * Get dsObservacao
     *
     * @return text 
     */
    public function getDsObservacao()
    {
        return $this->dsObservacao;
    }
}