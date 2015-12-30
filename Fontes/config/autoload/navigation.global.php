<?php

return array(
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Incial',
                'route' => 'home',
            ),
            array(
                'label' => 'Configuração',
                'route' => 'configuracao',
                'pages' => array(
                    array(
                        'label' => 'Perfil',
                        'route' => 'perfil',
                        'pages' => array(
                            array(
                                'label' => 'Listagem',
                                'route' => 'perfil',
                                'action' => 'index',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Adicionar',
                                'route' => 'perfil',
                                'action' => 'add',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Editar',
                                'route' => 'perfil',
                                'action' => 'edit',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Alterar Situação',
                                'route' => 'perfil',
                                'action' => 'ajax-alterar-situacao',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Víncular Usuário ao Perfil',
                                'route' => 'perfil-usuario',
                                'action' => 'index',
                                'visible' => false
                            ),
                        )
                    ),
                    array(
                        'label' => 'Acao',
                        'route' => 'acao',
                        'pages' => array(
                            array(
                                'label' => 'Listagem',
                                'route' => 'acao',
                                'action' => 'index',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Adicionar',
                                'route' => 'acao',
                                'action' => 'add',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Editar',
                                'route' => 'acao',
                                'action' => 'edit',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Alterar Situação',
                                'route' => 'acao',
                                'action' => 'ajax-alterar-situacao',
                                'visible' => false
                            ),
                        )
                    ),
                    array(
                        'label' => 'Pessoa',
                        'route' => 'pessoa',
                        'pages' => array(
                            array(
                                'label' => 'Listagem',
                                'route' => 'pessoa',
                                'action' => 'index',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Adicionar',
                                'route' => 'pessoa',
                                'action' => 'add',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Editar',
                                'route' => 'pessoa',
                                'action' => 'edit',
                                'visible' => false
                            ),
                            array(
                                'label' => 'Histórico de reenvio de senha',
                                'route' => 'pessoa',
                                'action' => 'historico-reenvio',
                                'visible' => false
                            ),
                        )
                    ),
                )
            ),
//            array(
//                'label' => 'Construcao',
//                'route' => 'contrucao-casa',
//                //'pages' => array()
//            ),
        ),
    )
);
