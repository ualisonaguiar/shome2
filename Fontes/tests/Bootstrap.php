<?php

namespace FinancasTest;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    protected static $serviceManager;

    protected static $entityManager;

    public static function init()
    {
        // Make everything relative to the root
        chdir(dirname(__DIR__));

        // Setup autoloading
        require_once(__DIR__ . '/../init_autoloader.php');

        // Run application
        $arrConfig = require('config/application.config.php');
        $arrConfig['module_listener_options']['config_glob_paths'] = array(
            'config/autoload/{{,*.}global,{,*.}local}.php',
            'config/autoload/doctrine.local-test.php'
        );
        \Zend\Mvc\Application::init($arrConfig);
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $arrConfig);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
        $serviceManager->get('ModuleManager')->loadModules();
        $serviceManager->setAllowOverride(true);
        self::$serviceManager = $serviceManager;

        # create structure database
        self::createStructureDatabase();
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (file_exists($vendorPath.'/autoload.php')) {
            include $vendorPath.'/autoload.php';
        }

        if (! class_exists('Zend\Loader\AutoloaderFactory')) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install`'
            );
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }

    public static function createStructureDatabase()
    {
        print_r("Criando a estrutura de dados de acordo com as entidades mapeadas.\n");
        $entityManager = self::getServiceManager()->get('Doctrine\ORM\EntityManager');
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->updateSchema($classes);
        print_r("Iniciando os testes unitários.\n\n");
    }
}

Bootstrap::init();
Bootstrap::chroot();
