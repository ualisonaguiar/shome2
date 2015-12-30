<?php

namespace PerfilTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Perfil\Controller\PerfilAcaoController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Http\Request as HttpRequest;
use FinancasTest\Bootstrap;
use CoreZend\TestUnit\TraitAutentication;
use Zend\Authentication\AuthenticationService;

class PerfilAcaoControllerTest extends AbstractHttpControllerTestCase
{
    use TraitAutentication;

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    public function setUp()
    {
        $this->setApplicationConfig(include realpath(__DIR__) . '/../../../../config/application.config.php');
        $this->controller = new PerfilAcaoController();
        $this->request = new Request();
        $this->event = new MvcEvent();
        $this->routeMatch = new RouteMatch(array('controller' => 'PerfilAcao'));
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator(Bootstrap::getServiceManager());
        parent::setUp();
        $this->makeLogin();
    }

    /**
     * @test
     * @covers \Authentication\Controller\IndexController::indexAction()
     */
    public function indexActionCanBeAccessed()
    {
        $this->dispatch('/perfil-acao');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Security');
        $this->assertControllerName('Perfil\Controller\PerfilAcao');
        $this->assertControllerClass('PerfilAcaoController');
        $this->assertMatchedRouteName('perfil-acao');
        $this->assertActionName('index');
    }
}
