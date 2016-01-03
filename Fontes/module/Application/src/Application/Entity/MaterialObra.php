<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\MaterialObra
 *
 * @ORM\Table(name="tb_material_obra")
 * @ORM\Entity
 */
class MaterialObra
{
    /**
     * @var integer $idMaterialObra
     *
     * @ORM\Column(name="id_material_obra", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMaterialObra;

    /**
     * @var string $dsMaterial
     *
     * @ORM\Column(name="ds_material", type="string", length=200, nullable=false)
     */
    private $dsMaterial;


    /**
     * Get idMaterialObra
     *
     * @return integer 
     */
    public function getIdMaterialObra()
    {
        return $this->idMaterialObra;
    }

    /**
     * Set dsMaterial
     *
     * @param string $dsMaterial
     * @return TbMaterialObra
     */
    public function setDsMaterial($dsMaterial)
    {
        $this->dsMaterial = $dsMaterial;
        return $this;
    }

    /**
     * Get dsMaterial
     *
     * @return string 
     */
    public function getDsMaterial()
    {
        return $this->dsMaterial;
    }
}