<?php

namespace Empreendimento\Form;

use CoreZend\Form\FormGenerator;

class ManterEmpreendimento extends FormGenerator
{
    public function prepareElementSearch(array $arrEstado = null)
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
                'value_options' => $arrEstado,
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
    
    public function prepareElementManter(array $arrEstado, $booRequired = true)
    {
        $this->addHidden('idEmpreendimento', array('id' => 'idEmpreendimento', 'required' => $booRequired));
        # Nome do empreendimento
        $this->addText(
            'dsEmpreendimento',
            array(
                'id' => 'dsEmpreendimento',
                'class' => 'form-control',
                'title' => 'Nome do Empreendimento',
                'placeholder' => 'Nome do Empreendimento',
                'required' => true,
                'maxlength' => 255
            ),
            array(
                'label' => 'Nome do Empreendimento:'
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
                'required' => true,
                'maxlength' => 10
            ),
            array(
                'label' => 'CEP:'
            )
        );
        # logradouro
        $this->addText(
            'dsLogradouro',
            array(
                'id' => 'dsLogradouro',
                'class' => 'form-control',
                'title' => 'Logradouro',
                'placeholder' => 'Nome do Empreendimento',
                'required' => true,
                'maxlength' => 255
            ),
            array(
                'label' => 'Logradouro:'
            )
        );        
        # bairro
        $this->addText(
            'dsBairro',
            array(
                'id' => 'dsBairro',
                'class' => 'form-control',
                'title' => 'Bairro',
                'placeholder' => 'Bairro',
                'required' => true,
                'maxlength' => 255
            ),
            array(
                'label' => 'Bairro:'
            )
        );        
        # complemento
        $this->addText(
            'dsComplemento',
            array(
                'id' => 'dsComplemento',
                'class' => 'form-control',
                'title' => 'Complemento/Número da Casa',
                'placeholder' => 'Complemento/Número da Casa',
                'required' => true,
                'maxlength' => 255
            ),
            array(
                'label' => 'Complemento/Número da Casa:'
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
                'value_options' => $arrEstado,
                'disable_inarray_validator' => true
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
                'disable_inarray_validator' => true
            )
        );
        # botao de voltar
        $this->addButton(
            'btnVoltar',
            array(
                'type'  => 'button',
                'class' => 'btn btn-primary',
                'title' => 'Voltar',
                'onclick' => "location.href='/empreendimento-obra'"
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
        $this->setInputFilter(new ManterEmpreendimentoFilter(__FUNCTION__));
    }
    
    public function setData($mixEmpreendimento, $serviceMunicipio = null)
    {
        if (is_object($mixEmpreendimento)) {
            $arrData = $mixEmpreendimento->toArray();
            $arrDataMunicipio = $serviceMunicipio
                ->fetchPairs(
                    'getIdMunicipio',
                    'getDsNome',
                    array('idEstado' => $mixEmpreendimento->getIdMunicipio()->getIdEstado()->getIdEstado())
                );
            
            $this->get('coMunicipio')->setAttribute('value_options', $arrDataMunicipio);
            $arrData['coEstado'] = $mixEmpreendimento->getIdMunicipio()->getIdEstado()->getIdEstado();
            $arrData['coMunicipio'] = $mixEmpreendimento->getIdMunicipio()->getIdMunicipio();
            return parent::setData($arrData);
        }        
        return parent::setData($mixEmpreendimento);
    }
}
