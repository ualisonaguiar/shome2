<?php

namespace Perfil\Form;

use CoreZend\Form\FormGenerator;

class VincularUsuarioPerfil extends FormGenerator
{
    public function prepareElementTela($arrLogin)
    {
        $this->setAttribute('name', 'formVinculoUsuarioPerfil');
        # campo id perfil
        $this->addHidden('idPerfil', array('id' => 'idPerfil', 'required' => true));
        # select contendo os logins do usuario
        $this->addSelect(
            'idLogin',
            array(
                'id' => 'idLogin',
                'class' => 'form-control',
                'title' => 'Selecione usuário abaixo que será vinculado ao perfil.',
                'required' => true,
            ),
            array(
                'label' => 'Usuário que será vinculado:',
                'value_options' => $arrLogin,
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
                'title' => 'Incluir Usuário'
            ),
            array(
                'label' => 'Incluir Usuário',
                'label_options' => array('disable_html_escape' => true)
            )
        );
    }
}
