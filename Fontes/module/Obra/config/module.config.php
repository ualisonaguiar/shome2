<?php

namespace Obra;

return array(
    'router' => array(
        'routes' => array(
            'projeto-obra' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto-obra[/:action][/:idPessoaFisica]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Projeto\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Projeto\Controller\Index' => 'Projeto\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    )
);
