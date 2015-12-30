<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Perfil\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Description of PessoaFisicaRepository
 *
 * @author ualison
 */
class PerfilRepository extends EntityRepository
{
    /**
     *
     * @param array $arrData
     * @param integer $intPage
     * @param integer $intQtdPage
     * @return Paginator
     */
    public function getListagem($arrData = array(), $intPage = 1, $intQtdPage = 10)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('Perefil')
            ->from('Application\Entity\Perfil', 'Perefil')
            ->setFirstResult($intPage * ($intPage - 1))
            ->orderBy('Perefil.noPerfil', 'asc');
        # bind nome
        if ($arrData['noPerfil']) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('Perfil.dsNome', ':noPerfil')
            )->setParameter('noPerfil', '%' . $arrData['noPerfil'] .  '%');
        }
        # bind situacao
        if ($arrData['inAtivo'] != '') {
            $queryBuilder->andWhere('Perefil.inAtivo = :inAtivo')
                ->setParameter('inAtivo', $arrData['inAtivo']);
        }
        $query = $queryBuilder->getQuery();
        $registerPaginator = new Paginator($query);
        $registerPaginator->setUseOutputWalkers(false);
        $intCountResult    = $registerPaginator->count();
        $arrDadosPaginator = array(
            'qtdRegister' => $intCountResult,
            'qtdPages' => ceil($intCountResult / $intQtdPage),
            'pageActual' => $intPage,
            'maxResult' => $intQtdPage,
            'register' => $registerPaginator
        );
        return $arrDadosPaginator;
    }

    /**
     *
     * @param type $intIdPerfil
     */
    public function getListagemLoginNaoVinculado($intIdPerfil)
    {
        /**
         * @TODO verificar o motivo do erro:[Semantical Error] line 0, col 24 near 'login.idLogin)': Error: 'login' is used outside the scope of its declaration.
         * @DATE 30/11/2015 - 0h26
         */
        $queryBuilder = $this->_em->createQueryBuilder();
        $arrLogin = $queryBuilder->select('login')
            ->from('Application\Entity\Login', 'login')
            ->getQuery()
            ->getResult();
        $arrLoginNot = array();
        foreach ($arrLogin as $login) {
            $arrLoginNot[] = $login->getIdLogin();
        }
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('perfil')
            ->from('Application\Entity\Perfil', 'perfil')
            ->where('perfil.idPerfil = :idPerfil')
            ->setParameter('idPerfil', $intIdPerfil)
            ->andWhere($queryBuilder->expr()->notIn('IDENTITY(perfil.idLogin)', ':idLogin'))
            ->setParameter('idLogin', $arrLoginNot)
            ->getQuery();
    }
}
