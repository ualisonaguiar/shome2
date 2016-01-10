<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\Municipio
 *
 * @ORM\Table(name="tb_municipio")
 * @ORM\Entity
 */
class Municipio
{
    /**
     * @var integer $idMunicipio
     *
     * @ORM\Column(name="id_municipio", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMunicipio;

    /**
     * @var integer $coMunicipioIbge
     *
     * @ORM\Column(name="co_municipio_ibge", type="integer", nullable=false)
     */
    private $coMunicipioIbge;

    /**
     * @var string $dsNome
     *
     * @ORM\Column(name="ds_nome", type="string", length=255, nullable=false)
     */
    private $dsNome;

    /**
     * @var Application\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id_estado")
     * })
     */
    private $idEstado;


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
     * Set coMunicipioIbge
     *
     * @param integer $coMunicipioIbge
     * @return TbMunicipio
     */
    public function setCoMunicipioIbge($coMunicipioIbge)
    {
        $this->coMunicipioIbge = $coMunicipioIbge;
        return $this;
    }

    /**
     * Get coMunicipioIbge
     *
     * @return integer
     */
    public function getCoMunicipioIbge()
    {
        return $this->coMunicipioIbge;
    }

    /**
     * Set dsNome
     *
     * @param string $dsNome
     * @return TbMunicipio
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
     * Set idEstado
     *
     * @param Application\Entity\Estado $idEstado
     * @return Municipio
     */
    public function setIdEstado(\Application\Entity\Estado $idEstado = null)
    {
        $this->idEstado = $idEstado;
        return $this;
    }

    /**
     * Get idEstado
     *
     * @return Application\Entity\TbEstado
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }
}