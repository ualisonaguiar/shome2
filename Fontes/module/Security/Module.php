<?php

namespace Security;

use Authentication\Service\Authentication as AuthenticationService;
use Perfil\Service\Perfil as PerfilService;
use Perfil\Service\PerfilUsuario as PerfilUsuarioService;
use Perfil\Service\PerfilAcao as PerfilAcaoService;
use Acao\Service\Acao as AcaoService;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'Authentication' => __DIR__ . '/src/Authentication',
                    'Perfil' => __DIR__ . '/src/Perfil',
                    'Pessoa' => __DIR__ . '/src/Pessoa',
                    'Acao' => __DIR__ . '/src/Acao',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Authentication\Service\Authentication' => function ($service) {
                    return new AuthenticationService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Authentication\AuthenticationService' => function ($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },
                'Perfil\Service\Perfil' => function ($service) {
                    return new PerfilService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Perfil\Service\PerfilUsuario' => function ($service) {
                    return new PerfilUsuarioService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Perfil\Service\PerfilAcao' => function ($service) {
                    return new PerfilAcaoService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Acao\Service\Acao' => function ($service) {
                    return new AcaoService($service->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }
}
