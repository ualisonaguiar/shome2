<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\LogMensageriaPessoaFisica
 *
 * @ORM\Table(name="tb_log_mensageria_pessoa_fisica")
 * @ORM\Entity
 */
class LogMensageriaPessoaFisica
{
    /**
     * @var integer $idLogMensageriaPessoaFisica
     *
     * @ORM\Column(name="id_log_mensageria_pessoa_fisica", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLogMensageriaPessoaFisica;

    /**
     * @var Application\Entity\MensageriaEmail
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\MensageriaEmail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mensageria_email", referencedColumnName="id_mensageria_email")
     * })
     */
    private $idMensageriaEmail;

    /**
     * @var Application\Entity\PessoaFisica
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\PessoaFisica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa_fisica", referencedColumnName="id_pessoa_fisica")
     * })
     */
    private $idPessoaFisica;


    /**
     * Get idLogMensageriaPessoaFisica
     *
     * @return integer
     */
    public function getIdLogMensageriaPessoaFisica()
    {
        return $this->idLogMensageriaPessoaFisica;
    }

    /**
     * Set idMensageriaEmail
     *
     * @param Application\Entity\MensageriaEmail $idMensageriaEmail
     * @return TbLogMensageriaPessoaFisica
     */
    public function setIdMensageriaEmail(\Application\Entity\MensageriaEmail $idMensageriaEmail = null)
    {
        $this->idMensageriaEmail = $idMensageriaEmail;
        return $this;
    }

    /**
     * Get idMensageriaEmail
     *
     * @return Application\Entity\TbMensageriaEmail
     */
    public function getIdMensageriaEmail()
    {
        return $this->idMensageriaEmail;
    }


    /**
     * Set idPessoaFisica
     *
     * @param Application\Entity\PessoaFisica $idPessoaFisica
     * @return TbLogMensageriaPessoaFisica
     */
    public function setIdPessoaFisica(\Application\Entity\PessoaFisica $idPessoaFisica = null)
    {
        $this->idPessoaFisica = $idPessoaFisica;
        return $this;
    }

    /**
     * Get idPessoaFisica
     *
     * @return Application\Entity\TbPessoaFisica
     */
    public function getIdPessoaFisica()
    {
        return $this->idPessoaFisica;
    }
}
