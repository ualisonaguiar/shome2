<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Mensageria\Service\MensageriaEmail as MensageriaEmailService;
use Mensageria\Service\ConfiguracaoEmail as ConfiguracaoEmailService;
use Application\Service\Estado as EstadoService;
use Application\Service\Municipio as MunicipioService;
use Application\Service\CEP as CepService;

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
                    'Mensageria' => __DIR__ . '/src/Mensageria',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Mensageria\Service\MensageriaEmail' => function ($service) {
                    return new MensageriaEmailService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Mensageria\Service\ConfiguracaoEmail' => function ($service) {
                    return new ConfiguracaoEmailService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Application\Service\Estado' => function ($service) {
                    return new EstadoService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Application\Service\Municipio' => function ($service) {
                    return new MunicipioService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Application\Service\CEP' => function () {
                    return new CepService();
                },
            )
        );
    }
}
