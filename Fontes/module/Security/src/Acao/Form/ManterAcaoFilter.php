<?php

namespace Acao\Form;

use CoreZend\Filter\FilterValidator;

class ManterAcaoFilter extends FilterValidator
{
    public function __construct($strFunction, $booRequiered)
    {
        switch ($strFunction) {
            case 'prepareElementForm':
                $this->filterManter($booRequiered);
                break;
            case 'prepareElementSearch':
                # Filter nome do perfil
                $this->addFilter(
                    'noPerfil',
                    'Nome do Perfil',
                    false,
                    null,
                    array($this->filterStringLength(255))
                );
                # Filter nome do perfil
                $this->addFilter(
                    'inAtivo',
                    'Situação do Perfil',
                    false,
                    null,
                    array($this->filterStringLength(255))
                );
                break;
        }
    }

    protected function filterManter($booRequiered)
    {
        # Filter id do acao
        $this->addFilter(
            'idAcao',
            'Chave primária da Ação',
            $booRequiered,
            null,
            array()
        );
        # Filter id do acao superior
        $this->addFilter(
            'idAcaoSuperior',
            'Chave estrangeira da Ação Superior',
            null,
            null,
            array()
        );
        # Filter id do acao superior
        $this->addFilter(
            'dsLabel',
            'Nome da ação',
            true,
            null,
            array($this->filterStringLength(250))
        );
        # Filter nome da rota
        $this->addFilter(
            'dsRoute',
            'Nome da Rota',
            true,
            null,
            array($this->filterStringLength(100))
        );
        # Filter nome da rota
        $this->addFilter(
            'dsAction',
            'Nome da ação',
            true,
            null,
            array($this->filterStringLength(100))
        );
        # Filter visibilidade
        $this->addFilter(
            'inVisible',
            'Visibilidade no menu',
            true,
            null,
            array()
        );
        # Filter visibilidade
        $this->addFilter(
            'inAtivo',
            'Situação',
            true,
            null,
            array()
        );
    }
}
