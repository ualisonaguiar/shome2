<?php

namespace SecuriryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Authentication\Controller\IndexController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Authentication\Message\Message;
use Zend\Http\Request as HttpRequest;
use FinancasTest\Bootstrap;
use CoreZend\TestUnit\TraitAutentication;
use Zend\Authentication\AuthenticationService;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    use Message,
        TraitAutentication;

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    public function setUp()
    {
        $this->setApplicationConfig(include realpath(__DIR__) . '/../../../../config/application.config.php');
        $this->controller = new IndexController();
        $this->request = new Request();
        $this->event = new MvcEvent();
        $this->routeMatch = new RouteMatch(array('controller' => 'authentication'));
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator(Bootstrap::getServiceManager());
        parent::setUp();
    }

    /**
     * @test
     * @covers \Authentication\Controller\IndexController::indexAction()
     */
    public function indexActionCanBeAccessed()
    {
        $this->dispatch('/authentication');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Authentication');
        $this->assertControllerName('Authentication\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('authentication');
        $this->assertActionName('index');
    }

    /**
     * @test
     * @covers \Authentication\Controller\IndexController::indexAction()
     * @depends indexActionCanBeAccessed
     */
    public function indexActionReturnView()
    {
        $this->routeMatch->setParam('action', 'index');
        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $arrVariables = $result->getVariables();
        $this->assertTrue(isset($arrVariables['form']));
        $this->assertInstanceOf('Authentication\Form\Login', $arrVariables['form']);
    }

    /**
     * @test
     * @covers \Authentication\Controller\IndexController::indexAction()
     * @dataProvider getListPostInValid
     */
    public function indexActionValidPost($intQtdError, $arrDataPost)
    {
        $this->dispatch('/authentication', HttpRequest::METHOD_POST, $arrDataPost);
        $flashMessager = new FlashMessenger();
        $this->assertCount($intQtdError, $flashMessager->getMessages());
    }

    /**
     * @test
     * @covers \Authentication\Controller\IndexController::indexAction()
     * @dataProvider getListPostInValid2
     */
    public function indexActionValidPost1($arrMessage, $arrDataPost)
    {
        $this->dispatch('/authentication', HttpRequest::METHOD_POST, $arrDataPost);
        $flashMessager = new FlashMessenger();
        $arrMessages = $flashMessager->getMessages();
        $this->assertSame($arrMessages[0]['danger'][0], $arrMessage[0]);
        $this->assertSame($arrMessages[1]['danger'][0], $arrMessage[1]);
    }

    /**
     * @test
     * @covers \Authentication\Controller\IndexController::logoffAction()
     */
    public function logoffAction()
    {
        $this->makeLogin();
        $authenticationService = new AuthenticationService();
        $this->assertTrue($authenticationService->hasIdentity());
        $this->dispatch('/authentication/logoff');
        $this->assertResponseStatusCode(302);
        $this->assertFalse($authenticationService->hasIdentity());
    }

    public function getListPostInValid2()
    {
        return array(
            array(
                array(
                    'Campo: Usuário obrigatório.',
                    'Campo: Senha obrigatório.',
                ),
                array()
            ),
            array(
                array(
                    $this->strMsgError01,
                    $this->strMsgError02,
                ),
                array(
                    'dsUsuario' => str_repeat('Teste', 160),
                    'dsPassword' => str_repeat('Teste', 160)
                ),
            )
        );
    }

    /**
     *
     * @return type
     */
    public function getListPostInValid()
    {
        return array(
            array(2, array()),
            array(1, array('dsUsuario' => 'Teste')),
            array(1, array('dsPassword' => 'Teste')),
            array(0, array('dsUsuario' => 'Teste', 'dsPassword' => 'Teste')),
            array(2, array('teste' => 'Teste', 'teste' => 'Teste')),
            array(2, array('dsUsuario' => str_repeat('Teste', 160), 'dsPassword' => str_repeat('Teste', 160))),
            array(0, array('dsUsuario' => str_repeat('P', 150), 'dsPassword' => str_repeat('A', 32))),
        );
    }
}
