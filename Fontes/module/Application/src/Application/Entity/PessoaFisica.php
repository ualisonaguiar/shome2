<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Application\Entity\TbPessoaFisica
 *
 * @ORM\Table(name="tb_pessoa_fisica")
 * @ORM\Entity(repositoryClass="Pessoa\Entity\PessoaFisicaRepository")
 */
class PessoaFisica
{
    /**
     * @var integer $idPessoaFisica
     *
     * @ORM\Column(name="id_pessoa_fisica", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPessoaFisica;

    /**
     * @var string $dsNome
     *
     * @ORM\Column(name="ds_nome", type="string", length=255, nullable=true)
     */
    private $dsNome;

    /**
     * @var string $dsEmail
     *
     * @ORM\Column(name="ds_email", type="string", length=150, nullable=true)
     */
    private $dsEmail;

    /**
     * @var string $dsCpf
     *
     * @ORM\Column(name="ds_cpf", type="string", length=11, nullable=true)
     */
    private $dsCpf;

    /**
     * @var date $datAniversario
     *
     * @ORM\Column(name="dat_aniversario", type="date", nullable=true)
     */
    private $datAniversario;

    /**
     * Get idPessoaFisica
     *
     * @return integer
     */
    public function getIdPessoaFisica()
    {
        return $this->idPessoaFisica;
    }

    /**
     * Set dsNome
     *
     * @param string $dsNome
     * @return TbPessoaFisica
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
     * Set dsEmail
     *
     * @param string $dsEmail
     * @return TbPessoaFisica
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
     * Set dsCpf
     *
     * @param string $dsCpf
     * @return TbPessoaFisica
     */
    public function setDsCpf($dsCpf)
    {
        $this->dsCpf = $dsCpf;
        return $this;
    }

    /**
     * Get dsCpf
     *
     * @return string
     */
    public function getDsCpf()
    {
        return $this->dsCpf;
    }


    /**
     * Set datAniversario
     *
     * @param date $datAniversario
     * @return TbPessoaFisica
     */
    public function setDatAniversario($datAniversario)
    {
        $this->datAniversario = $datAniversario;
        return $this;
    }

    /**
     * Get datAniversario
     *
     * @return \DateTime
     */
    public function getDatAniversario()
    {
        return $this->datAniversario->format('d/m/Y');
    }

    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->setUnderscoreSeparatedKeys(false);
        return $hydrator->extract($this);
    }
}
