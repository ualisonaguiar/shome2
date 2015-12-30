<?php

namespace CoreZend;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class Module
{

    /**
     *
     */
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('dispatch', array($this, 'checkAuthentication'));
        if (php_sapi_name() !== 'cli') {
            session_start();
        }
    }

    public function checkAuthentication(MvcEvent $event)
    {
        $auth = $event->getApplication()->getServiceManager()->get("Authentication\AuthenticationService");
        $target = $event->getTarget();
        $match = $event->getRouteMatch();
        if (!$auth->hasIdentity()) {
            $strController = $match->getParam('controller');
            $arrConfigAcl = $event->getApplication()->getServiceManager()->get('config')['acl']['public'];
            $flashMessenger = new FlashMessenger();
            $strAction = $match->getParam('action');
            $arrMessage = array('danger' => array('É preciso está autenticado para acessar esta funcionalidade.'));
            if (!array_key_exists($strController, $arrConfigAcl)) {
                $flashMessenger->addMessage($arrMessage);
                return $target->redirect()->toUrl('/authentication');
            }
            if (!in_array($strAction, $arrConfigAcl[$strController])) {
                $flashMessenger->addMessage($arrMessage);;
                return $target->redirect()->toUrl('/authentication');
            }
        }
    }

    /**
     *
     * @return type
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/',
                ),
            ),
        );
    }

}
