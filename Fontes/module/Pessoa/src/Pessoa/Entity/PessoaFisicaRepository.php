<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pessoa\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use CoreZend\Util\Format;

/**
 * Description of PessoaFisicaRepository
 *
 * @author ualison
 */
class PessoaFisicaRepository extends EntityRepository
{
    public function getListagem($arrData = array(), $intPage = 1, $intQtdPage = 10)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('PessoaFisica')
            ->addSelect('Login.dsLogin')
            ->from('Application\Entity\PessoaFisica', 'PessoaFisica')
            ->innerJoin(
                'Application\Entity\Login',
                'Login',
                'with',
                'Login.idPessoaFisica = PessoaFisica.idPessoaFisica'
            )
            ->setMaxResults($intQtdPage)
            ->setFirstResult($intPage * ($intPage - 1))
            ->orderBy('PessoaFisica.dsNome', 'asc');
        # bind nome
        if ($arrData['dsNome']) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('PessoaFisica.dsNome', ':dsNome')
            )->setParameter('dsNome', '%' . $arrData['dsNome'] .  '%');
        }
        # bind cpf
        if ($arrData['dsCpf']) {
            $queryBuilder->andWhere('PessoaFisica.dsCpf = :dsCpf')
                ->setParameter('dsCpf', Format::clearCpfCnpj($arrData['dsCpf']));
        }
        # bind dsEmail
        if ($arrData['dsEmail']) {
            $queryBuilder->andWhere('PessoaFisica.dsEmail = :dsEmail')
                ->setParameter('dsEmail', $arrData['dsEmail']);
        }
        # bind dsLogin
        if ($arrData['dsLogin']) {
            $queryBuilder->andWhere('Login.dsLogin = :dsLogin')
                ->setParameter('dsLogin', $arrData['dsLogin']);
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
}
