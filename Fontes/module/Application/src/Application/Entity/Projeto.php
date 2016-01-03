<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\Projeto
 *
 * @ORM\Table(name="tb_projeto")
 * @ORM\Entity
 */
class Projeto
{
    /**
     * @var integer $idProjeto
     *
     * @ORM\Column(name="id_projeto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProjeto;

    /**
     * @var string $dsProjeto
     *
     * @ORM\Column(name="ds_projeto", type="string", length=45, nullable=false)
     */
    private $dsProjeto;

    /**
     * @var date $datInicial
     *
     * @ORM\Column(name="dat_inicial", type="date", nullable=false)
     */
    private $datInicial;

    /**
     * @var date $datFinal
     *
     * @ORM\Column(name="dat_final", type="date", nullable=false)
     */
    private $datFinal;

    /**
     * @var boolean $inAtivo
     *
     * @ORM\Column(name="in_ativo", type="boolean", nullable=true)
     */
    private $inAtivo;

    /**
     * @var Application\Entity\Empreendimento
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Empreendimento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_empreendimento", referencedColumnName="id_empreendimento")
     * })
     */
    private $idEmpreendimento;


    /**
     * Get idProjeto
     *
     * @return integer 
     */
    public function getIdProjeto()
    {
        return $this->idProjeto;
    }

    /**
     * Set dsProjeto
     *
     * @param string $dsProjeto
     * @return TbProjeto
     */
    public function setDsProjeto($dsProjeto)
    {
        $this->dsProjeto = $dsProjeto;
        return $this;
    }

    /**
     * Get dsProjeto
     *
     * @return string 
     */
    public function getDsProjeto()
    {
        return $this->dsProjeto;
    }

    /**
     * Set datInicial
     *
     * @param date $datInicial
     * @return TbProjeto
     */
    public function setDatInicial($datInicial)
    {
        $this->datInicial = $datInicial;
        return $this;
    }

    /**
     * Get datInicial
     *
     * @return date 
     */
    public function getDatInicial()
    {
        return $this->datInicial;
    }

    /**
     * Set datFinal
     *
     * @param date $datFinal
     * @return TbProjeto
     */
    public function setDatFinal($datFinal)
    {
        $this->datFinal = $datFinal;
        return $this;
    }

    /**
     * Get datFinal
     *
     * @return date 
     */
    public function getDatFinal()
    {
        return $this->datFinal;
    }

    /**
     * Set inAtivo
     *
     * @param boolean $inAtivo
     * @return TbProjeto
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
     * Set idEmpreendimento
     *
     * @param Application\Entity\Empreendimento $idEmpreendimento
     * @return TbProjeto
     */
    public function setIdEmpreendimento(\Application\Entity\Empreendimento $idEmpreendimento = null)
    {
        $this->idEmpreendimento = $idEmpreendimento;
        return $this;
    }

    /**
     * Get idEmpreendimento
     *
     * @return Application\Entity\Empreendimento 
     */
    public function getIdEmpreendimento()
    {
        return $this->idEmpreendimento;
    }
}