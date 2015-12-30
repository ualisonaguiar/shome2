<?php

namespace Pessoa\Form;

use CoreZend\Filter\FilterValidator;
use Pessoa\Message\Message;
use Zend\Validator\Hostname;
use Zend\Validator\EmailAddress;

class ManterPessoaFilter extends FilterValidator
{
    use Message;

    public function __construct($booRequiered)
    {
        # Filter id da Pessoa Fisica
        $this->addFilter(
            'idPessoaFisica',
            'Chave primária da Pessoa Fisica',
            $booRequiered,
            null,
            array($this->filterStringLength(255, $this->strMsgError01))
        );
        # Filter nome
        $this->addFilter(
            'dsNome',
            'Nome',
            true,
            null,
            array($this->filterStringLength(255, $this->strMsgError01))
        );
        # Filter cpf
        $this->addFilter(
            'dsCpf',
            'CPF',
            true,
            null,
            array($this->filterStringLength(14, $this->strMsgError02))
        );
        # Filter email
        $this->addFilter(
            'dsEmail',
            'E-mail',
            true,
            null,
            array(
                $this->filterStringLength(150, $this->strMsgError03),
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'useMxCheck' => true,
                        'allow' => Hostname::ALLOW_DNS,
                        'message' => array(
                            EmailAddress::INVALID => $this->strMsgError05,
                            EmailAddress::INVALID_HOSTNAME => $this->strMsgError06,
                        )
                    ),
                ),
            )
        );
        # Filter login
        $this->addFilter(
            'dsLogin',
            'Login',
            true,
            null,
            array($this->filterStringLength(100, $this->strMsgError04))
        );
        # Filter data aniversario
        $this->addFilter(
            'datAniversario',
            'Data de aniversário',
            true,
            null,
            array(
                $this->filterStringLength(10, $this->strMsgError09),
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'd/m/Y'
                    ),
                )
            )
        );
    }
}
