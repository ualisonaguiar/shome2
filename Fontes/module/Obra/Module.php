<?php

namespace Obra;

use Empreendimento\Service\Empreendimento as EmpreendimentoService;
use Empreendimento\Service\Estado as EstadoService;

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
                    'Empreendimento' => __DIR__ . '/src/Empreendimento',
                    'Projeto' => __DIR__ . '/src/Projeto',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Empreendimento\Service\Empreendimento' => function ($service) {
                    return new EmpreendimentoService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Empreendimento\Service\Estado' => function ($service) {
                    return new EstadoService($service->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }
}
