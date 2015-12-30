<?php

namespace Acao\Form;

use CoreZend\Form\FormGenerator;
use Application\Entity\Acao as AcaoEntity;

class ManterAcao extends FormGenerator
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

    public function prepareElementForm($booRequiered = false, $arrAcaoSuperior = array())
    {
        $this->setAttribute('name', 'formManterAcao');
        $this->setAttributes(array('class' => 'form-horizontal'));
        # id acao
        $this->addHidden('idAcao', array('id' => 'idPerfil', 'required' => $booRequiered));
        # id acao superior
        $this->addSelect(
            'idAcaoSuperior',
            array(
                'id' => 'idAcaoSuperior',
                'class' => 'form-control',
                'title' => 'Ação para ser Vinculada',
                'required' => false,
            ),
            array(
                'label' => 'Ação para ser Vinculada:',
                'empty_option' => 'Selecione'
            )
        );
        # Label
        $this->addText(
            'dsLabel',
            array(
                'id' => 'dsLabel',
                'class' => 'form-control',
                'title' => 'Informe o nome da label da acao',
                'placeholder' => 'Informe o nome da label da acao',
                'required' => true,
                'maxlength' => 250
            ),
            array('label' => 'Nome da ação:')
        );
        # Rota
        $this->addText(
            'dsRoute',
            array(
                'id' => 'dsRoute',
                'class' => 'form-control',
                'title' => 'Informe a rota da ação',
                'placeholder' => 'Informe a rota da ação',
                'required' => true,
                'maxlength' => 100
            ),
            array('label' => 'Rota:')
        );
        # Acao
        $this->addText(
            'dsAction',
            array(
                'id' => 'dsAction',
                'class' => 'form-control',
                'title' => 'Informe a action',
                'placeholder' => 'Informe a action',
                'required' => true,
                'maxlength' => 100,
                'value' => 'index'
            ),
            array(
                'label' => 'Ação:',
            )
        );
        # visibilidade
        $this->addSelect(
            'inVisible',
            array(
                'id' => 'inVisible',
                'class' => 'form-control',
                'title' => 'Apresentar no menu',
                'required' => false,
            ),
            array(
                'label' => 'Apresentar no menu:',
                'value_options' => AcaoEntity::$arrApresentacaoMenu,
                'empty_option' => 'Selecione'
            )
        );
        # situacao
        $this->addSelect(
            'inAtivo',
            array(
                'id' => 'inAtivo',
                'class' => 'form-control',
                'title' => 'Situação da ação',
                'required' => false,
            ),
            array(
                'label' => 'Situação:',
                'value_options' => AcaoEntity::$arrSituacao,
                'empty_option' => 'Selecione'
            )
        );
        # botao de voltar
        $this->addButton(
            'btnVoltar',
            array(
                'type'  => 'button',
                'class' => 'btn btn-primary',
                'title' => 'Voltar',
                'onclick' => "location.href='/acao'"
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
        $this->setInputFilter(new ManterAcaoFilter(__FUNCTION__, $booRequiered));
    }
}
