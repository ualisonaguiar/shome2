<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\ProjetoPagamento
 *
 * @ORM\Table(name="tb_projeto_pagamento")
 * @ORM\Entity
 */
class ProjetoPagamento
{
    /**
     * @var integer $idProjetoPagamento
     *
     * @ORM\Column(name="id_projeto_pagamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProjetoPagamento;

    /**
     * @var decimal $vlrPagamento
     *
     * @ORM\Column(name="vlr_pagamento", type="decimal", nullable=false)
     */
    private $vlrPagamento;

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
     * @var Application\Entity\ItemMaterialProjeto
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ItemMaterialProjeto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_item_material_projeto", referencedColumnName="id_item_material_projeto")
     * })
     */
    private $idItemMaterialProjeto;

    /**
     * @var Application\Entity\MaterialObra
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\MaterialObra")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_material_obra", referencedColumnName="id_material_obra")
     * })
     */
    private $idMaterialObra;


    /**
     * Get idProjetoPagamento
     *
     * @return integer 
     */
    public function getIdProjetoPagamento()
    {
        return $this->idProjetoPagamento;
    }

    /**
     * Set vlrPagamento
     *
     * @param decimal $vlrPagamento
     * @return TbProjetoPagamento
     */
    public function setVlrPagamento($vlrPagamento)
    {
        $this->vlrPagamento = $vlrPagamento;
        return $this;
    }

    /**
     * Get vlrPagamento
     *
     * @return decimal 
     */
    public function getVlrPagamento()
    {
        return $this->vlrPagamento;
    }

    /**
     * Set dsAnexo
     *
     * @param string $dsAnexo
     * @return TbProjetoPagamento
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
     * @return TbProjetoPagamento
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
     * Set idItemMaterialProjeto
     *
     * @param Application\Entity\TbItemMaterialProjeto $idItemMaterialProjeto
     * @return TbProjetoPagamento
     */
    public function setIdItemMaterialProjeto(\Application\Entity\ItemMaterialProjeto $idItemMaterialProjeto = null)
    {
        $this->idItemMaterialProjeto = $idItemMaterialProjeto;
        return $this;
    }

    /**
     * Get idItemMaterialProjeto
     *
     * @return Application\Entity\TbItemMaterialProjeto 
     */
    public function getIdItemMaterialProjeto()
    {
        return $this->idItemMaterialProjeto;
    }

    /**
     * Set idMaterialObra
     *
     * @param Application\Entity\MaterialObra $idMaterialObra
     * @return TbProjetoPagamento
     */
    public function setIdMaterialObra(\Application\Entity\MaterialObra $idMaterialObra = null)
    {
        $this->idMaterialObra = $idMaterialObra;
        return $this;
    }

    /**
     * Get idMaterialObra
     *
     * @return Application\Entity\MaterialObra 
     */
    public function getIdMaterialObra()
    {
        return $this->idMaterialObra;
    }
}