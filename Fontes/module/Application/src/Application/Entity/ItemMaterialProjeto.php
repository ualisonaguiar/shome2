<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\ItemMaterialProjeto
 *
 * @ORM\Table(name="tb_item_material_projeto")
 * @ORM\Entity
 */
class ItemMaterialProjeto
{
    /**
     * @var integer $idItemMaterialProjeto
     *
     * @ORM\Column(name="id_item_material_projeto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idItemMaterialProjeto;

    /**
     * @var decimal $vlrUnitario
     *
     * @ORM\Column(name="vlr_unitario", type="decimal", nullable=false)
     */
    private $vlrUnitario;

    /**
     * @var decimal $nuQuantidade
     *
     * @ORM\Column(name="nu_quantidade", type="decimal", nullable=false)
     */
    private $nuQuantidade;

    /**
     * @var Application\Entity\ProjetoMaterial
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ProjetoMaterial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_projeto_material", referencedColumnName="id_projeto_material")
     * })
     */
    private $idProjetoMaterial;


    /**
     * Get idItemMaterialProjeto
     *
     * @return integer 
     */
    public function getIdItemMaterialProjeto()
    {
        return $this->idItemMaterialProjeto;
    }

    /**
     * Set vlrUnitario
     *
     * @param decimal $vlrUnitario
     * @return TbItemMaterialProjeto
     */
    public function setVlrUnitario($vlrUnitario)
    {
        $this->vlrUnitario = $vlrUnitario;
        return $this;
    }

    /**
     * Get vlrUnitario
     *
     * @return decimal 
     */
    public function getVlrUnitario()
    {
        return $this->vlrUnitario;
    }

    /**
     * Set nuQuantidade
     *
     * @param decimal $nuQuantidade
     * @return TbItemMaterialProjeto
     */
    public function setNuQuantidade($nuQuantidade)
    {
        $this->nuQuantidade = $nuQuantidade;
        return $this;
    }

    /**
     * Get nuQuantidade
     *
     * @return decimal 
     */
    public function getNuQuantidade()
    {
        return $this->nuQuantidade;
    }

    /**
     * Set idProjetoMaterial
     *
     * @param Application\Entity\TbProjetoMaterial $idProjetoMaterial
     * @return TbItemMaterialProjeto
     */
    public function setIdProjetoMaterial(\Application\Entity\ProjetoMaterial $idProjetoMaterial = null)
    {
        $this->idProjetoMaterial = $idProjetoMaterial;
        return $this;
    }

    /**
     * Get idProjetoMaterial
     *
     * @return Application\Entity\ProjetoMaterial 
     */
    public function getIdProjetoMaterial()
    {
        return $this->idProjetoMaterial;
    }
}