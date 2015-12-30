<?php

namespace Pessoa\Form;

use CoreZend\Form\FormGenerator;

class Listagem extends FormGenerator
{
    public function prepareElementForm()
    {
        $this->setAttribute('name', 'formSearchPessoaFisica');
        # botao de cadastrar
        $this->addButton(
            'btnCadastro',
            array(
                'class' => 'btn btn-success',
                'title' => 'Cadastrar novo usuário',
                'onclick' => "location.href='/pessoa/add'"
            ),
            array(
                'label' => 'Cadastro',
                'label_options' => array('disable_html_escape' => true)
            )
        );
        # Nome
        $this->addText(
            'dsNome',
            array(
                'id' => 'dsNome',
                'class' => 'form-control',
                'title' => 'Nome do Usuário',
                'placeholder' => 'Nome do Usuário',
                'required' => false
            ),
            array('label' => 'Nome do Usuário:')
        );
        # CPF/CNPF
        $this->addCpf(
            'dsCpf',
            array(
                'id' => 'dsCpf',
                'class' => 'form-control',
                'title' => 'CPF do usuário',
                'placeholder' => 'CPF do usuário',
                'required' => false,
            ),
            array('label' => 'CPF do usuário:')
        );
        # email
        $this->addEmail(
            'dsEmail',
            array(
                'id' => 'dsEmail',
                'class' => 'form-control',
                'title' => 'E-mail do usuário',
                'placeholder' => 'E-mail do usuário',
                'required' => false,
            ),
            array('label' => 'E-mail do usuário:')
        );
        # nome usuario
        $this->addText(
            'dsLogin',
            array(
                'id' => 'dsLogin',
                'class' => 'form-control',
                'title' => 'Login do usuário',
                'placeholder' => 'Login do usuário',
                'required' => false,
            ),
            array('label' => 'Login do usuário:')
        );
        # botao de limpar
        $this->addButton(
            'btnClear',
            array(
                'id' => 'btnClear',
                'type'  => 'button',
                'class' => 'btn btn-default',
                'title' => 'Limpar'
            ),
            array(
                'label' => 'Limpar',
                'label_options' => array('disable_html_escape' => true,)
            )
        );
        # botao de pesquisa
        $this->addButton(
            'btnPesquisar',
            array(
                'id' => 'btnPesquisar',
                'type'  => 'button',
                'class' => 'btn btn-info',
                'title' => 'Pesquisar'
            ),
            array(
                'label' => 'Pesquisar',
                'label_options' => array('disable_html_escape' => true,)
            )
        );
    }
}
