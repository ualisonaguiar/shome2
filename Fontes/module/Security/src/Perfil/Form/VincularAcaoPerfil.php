<?php

namespace Perfil\Form;

use CoreZend\Form\FormGenerator;

class VincularAcaoPerfil extends FormGenerator
{
    public function prepareElementTela($arrAcao)
    {
        $this->setAttribute('name', 'formVinculoAcaoPerfil');
        # campo id perfil
        $this->addHidden('idPerfil', array('id' => 'idPerfil', 'required' => true));
        # select contendo os logins do usuario
        $this->addSelect(
            'idAcao',
            array(
                'id' => 'idAcao',
                'class' => 'form-control',
                'title' => 'Selecione ação abaixo que será vinculado ao perfil.',
                'required' => true,
            ),
            array(
                'label' => 'Ação que será vinculado:',
                'value_options' => $arrAcao,
                'empty_option' => 'Selecione'
            )
        );
        # botao de incluir
        $this->addButton(
            'btnVincular',
            array(
                'id' => 'btnVincular',
                'type'  => 'button',
                'class' => 'btn btn-success',
                'title' => 'Incluir Ação'
            ),
            array(
                'label' => 'Incluir Ação',
                'label_options' => array('disable_html_escape' => true)
            )
        );
    }
}
