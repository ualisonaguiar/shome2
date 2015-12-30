<?php

namespace Obra;

return array(
    'router' => array(
        'routes' => array(
            'obra' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/diario-obra[/:action][/:idPessoaFisica]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Pessoa\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Pessoa\Controller\Index' => 'Pessoa\Controller\IndexController'
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
