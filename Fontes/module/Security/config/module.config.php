<?php

namespace Security;

return array(
    'router' => array(
        'routes' => array(
            'authentication' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/authentication[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Authentication\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'perfil' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/perfil[/:action][/:idPerfil]',
                    'constraints' => array(
                        'idPerfil' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Perfil\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'perfil-usuario' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/perfil-usuario[/:action][/:idPerfil]',
                    'constraints' => array(
                        'idPerfil' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Perfil\Controller\PerfilUsuario',
                        'action' => 'index',
                    ),
                ),
            ),
            'perfil-acao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/perfil-acao[/:action][/:idPerfil]',
                    'constraints' => array(
                        'idPerfil' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Perfil\Controller\PerfilAcao',
                        'action' => 'index',
                    ),
                ),
            ),
            'acao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/acao[/:action][/:idAcao]',
                    'constraints' => array(
                        'idAcao' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Acao\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Authentication\Controller\Index' => 'Authentication\Controller\IndexController',
            'Perfil\Controller\Index' => 'Perfil\Controller\IndexController',
            'Perfil\Controller\PerfilUsuario' => 'Perfil\Controller\PerfilUsuarioController',
            'Perfil\Controller\PerfilAcao' => 'Perfil\Controller\PerfilAcaoController',
            'Acao\Controller\Index' => 'Acao\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\Login',
                'identity_property' => 'dsLogin',
                'credential_property' => 'dsPassword',
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    )
);
