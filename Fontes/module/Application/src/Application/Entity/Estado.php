<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\Estado
 *
 * @ORM\Table(name="tb_estado")
 * @ORM\Entity
 */
class Estado
{
    /**
     * @var integer $idEstado
     *
     * @ORM\Column(name="id_estado", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEstado;

    /**
     * @var integer $coEstadoIbge
     *
     * @ORM\Column(name="co_estado_ibge", type="integer", nullable=false)
     */
    private $coEstadoIbge;

    /**
     * @var string $dsEstado
     *
     * @ORM\Column(name="ds_estado", type="string", length=100, nullable=false)
     */
    private $dsEstado;

    /**
     * @var string $dsSigla
     *
     * @ORM\Column(name="ds_sigla", type="string", length=2, nullable=false)
     */
    private $dsSigla;

    /**
     * @var string $dsRegiao
     *
     * @ORM\Column(name="ds_regiao", type="string", length=50, nullable=false)
     */
    private $dsRegiao;


    /**
     * Get idEstado
     *
     * @return integer
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * Set coEstadoIbge
     *
     * @param integer $coEstadoIbge
     * @return TbEstado
     */
    public function setCoEstadoIbge($coEstadoIbge)
    {
        $this->coEstadoIbge = $coEstadoIbge;
        return $this;
    }

    /**
     * Get coEstadoIbge
     *
     * @return integer
     */
    public function getCoEstadoIbge()
    {
        return $this->coEstadoIbge;
    }

    /**
     * Set dsEstado
     *
     * @param string $dsEstado
     * @return TbEstado
     */
    public function setDsEstado($dsEstado)
    {
        $this->dsEstado = $dsEstado;
        return $this;
    }

    /**
     * Get dsEstado
     *
     * @return string
     */
    public function getDsEstado()
    {
        return $this->dsEstado;
    }

    /**
     * Set dsSigla
     *
     * @param string $dsSigla
     * @return TbEstado
     */
    public function setDsSigla($dsSigla)
    {
        $this->dsSigla = $dsSigla;
        return $this;
    }

    /**
     * Get dsSigla
     *
     * @return string
     */
    public function getDsSigla()
    {
        return $this->dsSigla;
    }

    /**
     * Set dsRegiao
     *
     * @param string $dsRegiao
     * @return TbEstado
     */
    public function setDsRegiao($dsRegiao)
    {
        $this->dsRegiao = $dsRegiao;
        return $this;
    }

    /**
     * Get dsRegiao
     *
     * @return string
     */
    public function getDsRegiao()
    {
        return $this->dsRegiao;
    }
}