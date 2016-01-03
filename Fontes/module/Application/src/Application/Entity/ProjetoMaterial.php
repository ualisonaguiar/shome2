<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\ProjetoMaterial
 *
 * @ORM\Table(name="tb_projeto_material")
 * @ORM\Entity
 */
class ProjetoMaterial
{
    /**
     * @var integer $idProjetoMaterial
     *
     * @ORM\Column(name="id_projeto_material", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProjetoMaterial;

    /**
     * @var date $datCompra
     *
     * @ORM\Column(name="dat_compra", type="date", nullable=false)
     */
    private $datCompra;

    /**
     * @var string $dsAnexo
     *
     * @ORM\Column(name="ds_anexo", type="string", length=200, nullable=true)
     */
    private $dsAnexo;

    /**
     * @var text $dsObservacao
     *
     * @ORM\Column(name="ds_observacao", type="text", nullable=true)
     */
    private $dsObservacao;

    /**
     * @var Application\Entity\Projeto
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Projeto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_projeto", referencedColumnName="id_projeto")
     * })
     */
    private $idProjeto;

    /**
     * Get idProjetoMaterial
     *
     * @return integer
     */
    public function getIdProjetoMaterial()
    {
        return $this->idProjetoMaterial;
    }

    /**
     * Set datCompra
     *
     * @param date $datCompra
     * @return TbProjetoMaterial
     */
    public function setDatCompra($datCompra)
    {
        $this->datCompra = $datCompra;
        return $this;
    }

    /**
     * Get datCompra
     *
     * @return date
     */
    public function getDatCompra()
    {
        return $this->datCompra;
    }

    /**
     * Set dsAnexo
     *
     * @param string $dsAnexo
     * @return TbProjetoMaterial
     */
    public function setDsAnexo($dsAnexo)
    {
        $this->dsAnexo = $dsAnexo;
        return $this;
    }

    /**
     * Get dsAnexo
     *
     * @return string
     */
    public function getDsAnexo()
    {
        return $this->dsAnexo;
    }

    /**
     * Set dsObservacao
     *
     * @param text $dsObservacao
     * @return TbProjetoMaterial
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

    /**
     * Set idProjeto
     *
     * @param text $idProjeto
     * @return Projeto
     */
    public function setIdProjeto(\Application\Entity\Projeto $idProjeto)
    {
        $this->idProjeto = $idProjeto;
        return $this;
    }

    /**
     * Get idProjeto
     *
     * @return text
     */
    public function getIdProjeto()
    {
        return $this->idProjeto;
    }
}