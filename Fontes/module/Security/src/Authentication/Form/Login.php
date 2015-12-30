<?php

namespace Authentication\Form;

use CoreZend\Form\FormGenerator;

class Login extends FormGenerator
{
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }

    public function makeElement()
    {
        $this->setAttributes(['class' => 'form-signin']);
        # input login
        $this->addText(
            'dsUsuario',
            array(
                'id' => 'dsUsuario',
                'class' => 'form-control',
                'required' => true,
                'placeholder' => 'Usuário:',
                'autocomplete' => false,
                'autofocus' => true,
                'maxlength' => 150
            ),
            array(
                'label' => 'Usuário',
            )
        );
        # input password
        $this->addPassword(
            'dsPassword',
            array(
                'id' => 'dsPassword',
                'class' => 'form-control',
                'required' => true,
                'placeholder' => 'Senha:',
                'autocomplete' => false,
                'maxlength' => 32
            )
        );
        # butao de logar
        $this->addButton(
            'submit',
            array(
                'class' => 'btn btn-success',
                'isTranslate' => true,
                'type' => 'submit',
                'title' => 'Entrar'
            ),
            array(
                'label' => 'Entrar'
            )
        );
        $this->setInputFilter(new LoginFilter());
    }
}
