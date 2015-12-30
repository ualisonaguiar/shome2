<?php

namespace Pessoa\Form;

use CoreZend\Form\FormGenerator;

class ManterPessoa extends FormGenerator
{
    public function prepareElementForm($booRequiered)
    {
        $this->setAttribute('name', 'formPessoaFisica');
        $this->setAttributes(array('class' => 'form-horizontal'));
        # id pessoa fisica
        $this->addHidden('idPessoaFisica', array('id' => 'idPessoaFisica'));
        # Nome
        $this->addText(
            'dsNome',
            array(
                'id' => 'dsNome',
                'class' => 'form-control',
                'title' => 'Informe o nome',
                'placeholder' => 'Informe o nome',
                'required' => true
            ),
            array('label' => 'Nome:')
        );
        # CPF/CNPF
        $this->addCpf(
            'dsCpf',
            array(
                'id' => 'dsCpf',
                'class' => 'form-control',
                'title' => 'Informe o CPF do usuário',
                'placeholder' => 'Informe o CPF do usuário',
                'required' => true,
            ),
            array('label' => 'CPF:')
        );
        # email
        $this->addEmail(
            'dsEmail',
            array(
                'id' => 'dsEmail',
                'class' => 'form-control',
                'title' => 'Informe o E-mail do usuário',
                'placeholder' => 'Informe o E-mail do usuário',
                'required' => true,
            ),
            array('label' => 'E-mail do usuário:')
        );
        # data aniversario
        $this->addDate(
            'datAniversario',
            array(
                'id' => 'datAniversario',
                'class' => 'form-control',
                'title' => 'Informe a data de aniversário',
                'placeholder' => 'Informe a data de aniversário',
                'required' => true,
            ),
            array('label' => 'Data de aniversário do usuário:')
        );
        # nome usuario
        $this->addText(
            'dsLogin',
            array(
                'id' => 'dsLogin',
                'class' => 'form-control',
                'title' => 'Informe o login que será utilizado',
                'placeholder' => 'Informe o login que será utilizado',
                'required' => true,
            ),
            array('label' => 'Informe o login que será utilizado:')
        );
        # botao de voltar
        $this->addButton(
            'btnVoltar',
            array(
                'type'  => 'button',
                'class' => 'btn btn-primary',
                'title' => 'Voltar',
                'onclick' => "location.href='/pessoa'"
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
        $this->setInputFilter(new ManterPessoaFilter($booRequiered));
        return $this;
    }

    public function setData($arrPost)
    {
        if (array_key_exists('dsCpf', $arrPost)) {
            $arrPost['dsCpf'] = str_replace(array('.', '-'), '', $arrPost['dsCpf']);
        }
        return parent::setData($arrPost);
    }
}
