<?php

namespace Empreendimento\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class EmpreendimentoRepository extends EntityRepository
{
    public function getListagem($arrData = array(), $intPage = 1, $intQtdPage = 10)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('Empreendimento')
            ->from('Application\Entity\Empreendimento', 'Empreendimento')
            ->setMaxResults($intQtdPage)
            ->setFirstResult($intPage * ($intPage - 1))
            ->orderBy('Empreendimento.dsEmpreendimento', 'asc');
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
