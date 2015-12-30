<?php

namespace Perfil\Form;

use CoreZend\Form\FormGenerator;
use Application\Entity\Perfil as PerfilEntity;

class ManterPerfil extends FormGenerator
{
    public function prepareElementSearch()
    {
        $this->setAttribute('name', 'formSearchPerfil');
        # botao de cadastrar
        $this->addButton(
            'btnCadastro',
            array(
                'class' => 'btn btn-success',
                'title' => 'Cadastrar novo perfil',
                'onclick' => "location.href='/perfil/add'"
            ),
            array(
                'label' => 'Cadastro',
                'label_options' => array('disable_html_escape' => true)
            )
        );
        $this->setAttributes(array('class' => 'form-horizontal'));
        # Nome
        $this->addText(
            'noPerfil',
            array(
                'id' => 'noPerfil',
                'class' => 'form-control',
                'title' => 'Informe o nome do perfil',
                'placeholder' => 'Informe o nome do perfil',
                'required' => false,
                'maxlength' => 255
            ),
            array('label' => 'Perfil:')
        );
        # situacao
        $this->addSelect(
            'inAtivo',
            array(
                'id' => 'inAtivo',
                'class' => 'form-control',
                'title' => 'Situação do perfil',
                'required' => false,
            ),
            array(
                'label' => 'Situação:',
                'value_options' => PerfilEntity::$arrSituacao,
                'empty_option' => 'Selecionar a situação do Perfil'
            )
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
        $this->setInputFilter(new ManterPerfilFilter(__FUNCTION__, false));
    }

    public function prepareElementForm($booRequiered = false)
    {
        $this->setAttribute('name', 'formManterPerfil');
        $this->setAttributes(array('class' => 'form-horizontal'));
        # id perfil
        $this->addHidden('idPerfil', array('id' => 'idPerfil', 'required' => $booRequiered));
        # Nome
        $this->addText(
            'noPerfil',
            array(
                'id' => 'noPerfil',
                'class' => 'form-control',
                'title' => 'Informe o nome do perfil',
                'placeholder' => 'Informe o nome do perfil',
                'required' => true,
                'maxlength' => 255
            ),
            array('label' => 'Perfil:')
        );
        # descricao
        $this->addText(
            'dsPerfil',
            array(
                'id' => 'dsPerfil',
                'class' => 'form-control',
                'title' => 'Informe descrição do perfil',
                'placeholder' => 'Informe descrição do perfil',
                'required' => true,
                'maxlength' => 400
            ),
            array('label' => 'Descrição:')
        );
        # botao de voltar
        $this->addButton(
            'btnVoltar',
            array(
                'type'  => 'button',
                'class' => 'btn btn-primary',
                'title' => 'Voltar',
                'onclick' => "location.href='/perfil'"
            ),
            array(
                'label' => 'Voltar',
                'label_options' => array('disable_html_escape' => true,)
            )
        );
        # botao de salvar
        $this->addButton(
            'btnSalvar',
            array(
                'type'  => 'submit',
                'class' => 'btn btn-success',
                'title' => 'Salvar'
            ),
            array(
                'label' => 'Salvar',
                'label_options' => array('disable_html_escape' => true)
            )
        );
        $this->setInputFilter(new ManterPerfilFilter(__FUNCTION__, $booRequiered));
    }
}
