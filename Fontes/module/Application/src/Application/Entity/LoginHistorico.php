<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Entity\TbLoginHistorico
 *
 * @ORM\Table(name="tb_login_historico")
 * @ORM\Entity
 */
class LoginHistorico
{
    /**
     * @var integer $idLoginHistorico
     *
     * @ORM\Column(name="id_login_historico", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLoginHistorico;

    /**
     * @var integer $coSituacaoLogin
     *
     * @ORM\Column(name="co_situacao_login", type="integer", nullable=false)
     */
    private $coSituacaoLogin;

    /**
     * @var datetime $datHistorico
     *
     * @ORM\Column(name="dat_historico", type="datetime", nullable=true)
     */
    private $datHistorico;

    /**
     * @var Application\Entity\Login
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Login")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_login", referencedColumnName="id_login")
     * })
     */
    private $idLogin;


    /**
     * Get idLoginHistorico
     *
     * @return integer
     */
    public function getIdLoginHistorico()
    {
        return $this->idLoginHistorico;
    }

    /**
     * Set coSituacaoLogin
     *
     * @param integer $coSituacaoLogin
     * @return TbLoginHistorico
     */
    public function setCoSituacaoLogin($coSituacaoLogin)
    {
        $this->coSituacaoLogin = $coSituacaoLogin;
        return $this;
    }

    /**
     * Get coSituacaoLogin
     *
     * @return integer
     */
    public function getCoSituacaoLogin()
    {
        return $this->coSituacaoLogin;
    }

    /**
     * Set datHistorico
     *
     * @param datetime $datHistorico
     * @return TbLoginHistorico
     */
    public function setDatHistorico($datHistorico)
    {
        $this->datHistorico = $datHistorico;
        return $this;
    }

    /**
     * Get datHistorico
     *
     * @return datetime
     */
    public function getDatHistorico()
    {
        return $this->datHistorico;
    }

    /**
     * Set idLogin
     *
     * @param Application\Entity\Login $idLogin
     * @return TbLoginHistorico
     */
    public function setIdLogin(\Application\Entity\Login $idLogin = null)
    {
        $this->idLogin = $idLogin;
        return $this;
    }

    /**
     * Get idLogin
     *
     * @return Application\Entity\TbLogin
     */
    public function getIdLogin()
    {
        return $this->idLogin;
    }
}
