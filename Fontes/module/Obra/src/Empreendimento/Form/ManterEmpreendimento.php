<?php

namespace Empreendimento\Form;

use CoreZend\Form\FormGenerator;

class ManterEmpreendimento extends FormGenerator
{
    public function prepareElementSearch()
    {
        $this->setAttributes(
            array(
                'class' => 'form-horizontal',
                'name' => 'formSearchEmpreendimento'
            )
        );
        # botao de cadastrar
        $this->addButton(
            'btnCadastro',
            array(
                'class' => 'btn btn-success',
                'title' => 'Cadastrar novo usuário',
                'onclick' => "location.href='/empreendimento-obra/add'"
            ),
            array(
                'label' => 'Cadastro',
                'label_options' => array('disable_html_escape' => true)
            )
        );
        # Nome do empreendimento
        $this->addText(
            'dsEmpreendimento',
            array(
                'id' => 'dsEmpreendimento',
                'class' => 'form-control',
                'title' => 'Nome do Empreendimento',
                'placeholder' => 'Nome do Empreendimento',
                'required' => false,
                'maxlength' => 255
            ),
            array(
                'label' => 'Nome do Empreendimento:'
            )
        );
        # Estado
        $this->addSelect(
            'coEstado',
            array(
                'id' => 'coEstado',
                'class' => 'form-control',
                'title' => 'Estado',
                'required' => false,
            ),
            array(
                'label' => 'Estado:',
                'empty_option' => 'Selecione',
                'value_options' => array(),
            )
        );
        # Municipio
        $this->addSelect(
            'coMunicipio',
            array(
                'id' => 'coMunicipio',
                'class' => 'form-control',
                'title' => 'Munícipio',
                'required' => false,
            ),
            array(
                'label' => 'Munícipio:',
                'empty_option' => 'Selecione',
                'value_options' => array(),
            )
        );
        # Bairro
        $this->addText(
            'dsBairro',
            array(
                'id' => 'dsBairro',
                'class' => 'form-control',
                'title' => 'Bairro',
                'placeholder' => 'Bairro',
                'required' => false,
                'maxlength' => 100
            ),
            array(
                'label' => 'Bairro:'
            )
        );
        # CEP
        $this->addCep(
            'coCep',
            array(
                'id' => 'coCep',
                'class' => 'form-control',
                'title' => 'CEP',
                'placeholder' => 'CEP',
                'required' => false,
                'maxlength' => 10
            ),
            array(
                'label' => 'CEP:'
            )
        );
//        # CPF Empreendimento
//        $this->addCpf(
//            'coCPf',
//            array(
//                'id' => 'coCPf',
//                'class' => 'form-control',
//                'title' => 'CPF Responsável do Empreendimento',
//                'placeholder' => 'CPF Responsável do Empreendimento',
//                'required' => false,
//                'maxlength' => 13
//            ),
//            array(
//                'label' => 'CPF Responsável do Empreendimento:'
//            )
//        );
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
        $this->setInputFilter(new ManterEmpreendimentoFilter(__FUNCTION__));
    }
}
