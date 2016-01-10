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
            case 'prepareElementManter':
                $this->filterElementManter($booRequired);
                break;
        }
    }
    
    protected function filterElementManter($booRequired)
    {
        $this->addFilter(
            'idEmpreendimento',
            'Id do Empreendimento',
            $booRequired,
            null,
            array()
        );        
        $this->addFilter(
            'dsEmpreendimento',
            'Nome do Empreendimento',
            true,
            null,
            array()
        );        
        $this->addFilter(
            'coCep',
            'CEP',
            true,
            null,
            array()
        );        
        $this->addFilter(
            'dsLogradouro',
            'Logradouro',
            true,
            null,
            array()
        );        
        $this->addFilter(
            'dsBairro',
            'Bairro',
            true,
            null,
            array()
        );        
        $this->addFilter(
            'dsComplemento',
            'Complemento',
            true,
            null,
            array()
        );        
        $this->addFilter(
            'coEstado',
            'Estado',
            true,
            null,
            array()
        );        
        $this->addFilter(
            'coMunicipio',
            'Municipio',
            true,
            null,
            array()
        );        
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
