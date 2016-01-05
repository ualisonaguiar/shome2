<?php

namespace Empreendimento\Form;

use CoreZend\Filter\FilterValidator;

class ManterEmpreendimentoFilter extends FilterValidator
{

    public function __construct($strFunction, $booRequired = false)
    {
        switch ($strFunction) {
            case 'prepareElementSearch':
                $this->filterElementSearch();
                break;
        }
    }

    protected function filterElementSearch()
    {
        # Filter Empreendimento
        $this->addFilter(
            'dsEmpreendimento',
            'Nome do Empreendimento',
            false,
            null,
            array()
        );
        # Filter Codigo Estado
        $this->addFilter(
            'coEstado',
            'Código do Estado',
            false,
            null,
            array()
        );
        # Filter Codigo Municipio
        $this->addFilter(
            'coMunicipio',
            'Código do Munícipio',
            false,
            null,
            array()
        );
        # Filter Bairro
        $this->addFilter(
            'dsBairro',
            'Bairro',
            false,
            null,
            array()
        );
        # Filter CEP
        $this->addFilter(
            'coCep',
            'CEP',
            false,
            null,
            array()
        );
    }
}
