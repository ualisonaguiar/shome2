<?php

namespace Perfil\Form;

use CoreZend\Filter\FilterValidator;

class ManterPerfilFilter extends FilterValidator
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
        # Filter id do perfil
        $this->addFilter(
            'idPerfil',
            'Chave primária do Perfil',
            $booRequiered,
            null,
            array($this->filterStringLength(255))
        );
        # Filter nome do perfil
        $this->addFilter(
            'noPerfil',
            'Nome do Perfil',
            true,
            null,
            array($this->filterStringLength(255))
        );
        # Filter descricao do perfil
        $this->addFilter(
            'dsPerfil',
            'Descrição do Perfil',
            true,
            null,
            array($this->filterStringLength(400))
        );
    }
}
