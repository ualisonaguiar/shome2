<?php

namespace Pessoa;

use Pessoa\Service\PessoaFisica as PessoaFisicaService;
use Pessoa\Service\LogMensageriaPessoaFisica as LogMensageriaPessoaFisicaService;

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
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Pessoa\Service\PessoaFisica' => function ($service) {
                    return new PessoaFisicaService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Pessoa\Service\LogMensageriaPessoaFisica' => function ($service) {
                    return new LogMensageriaPessoaFisicaService($service->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }
}
