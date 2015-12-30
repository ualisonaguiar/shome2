<?php

namespace Authentication\Form;

use CoreZend\Filter\FilterValidator;
use Authentication\Message\Message;

class LoginFilter extends FilterValidator
{
    use Message;

    public function __construct()
    {
        # Filter usuario
        $this->addFilter(
            'dsUsuario',
            'Usuário',
            true,
            null,
            array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 150,
                        'message' => array(
                            'stringLengthTooLong' => $this->strMsgError01
                        )
                    ),
                )
            )
        );

        # Filter password
        $this->addFilter(
            'dsPassword',
            'Senha',
            true,
            null,
            array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 32,
                        'message' => array(
                            'stringLengthTooLong' => $this->strMsgError02
                        )
                    ),
                )
            )
        );
    }
}
