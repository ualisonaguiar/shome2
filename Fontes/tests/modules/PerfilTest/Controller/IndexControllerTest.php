<?php

namespace PerfilTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use CoreZend\TestUnit\TraitAutentication;
use Perfil\Controller\IndexController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use FinancasTest\Bootstrap;
use Zend\Stdlib\Parameters;
use CoreZend\Util\String;

class IndexControllerTest extends AbstractHttpControllerTestCase
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
        $this->controller = new IndexController();
        $this->request = new Request();
        $this->event = new MvcEvent();
        $this->routeMatch = new RouteMatch(array('controller' => 'perfil'));
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator(Bootstrap::getServiceManager());
        parent::setUp();
        $this->makeLogin();
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::__construct()
     */
    public function construct()
    {
        $this->assertInstanceOf('Perfil\Controller\IndexController', $this->controller);
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::indexAction()
     */
    public function indexActionReturnView()
    {
        $this->routeMatch->setParam('action', 'index');
        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::addAction()
     */
    public function addActionReturnView()
    {
        $this->dispatch('/perfil/add');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Perfil');
        $this->assertControllerName('Perfil\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('perfil');
        $this->assertActionName('add');
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::editAction()
     */
    public function editActionReturnView()
    {
        $this->dispatch('/perfil/edit/1');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('Perfil');
        $this->assertControllerName('Perfil\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('perfil');
        $this->assertActionName('edit');
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::addAction()
     */
    public function addActionPost()
    {
        $parameter = new Parameters(
            array(
                'noPerfil' => String::generateRandomExpression(255),
                'dsPerfil' => String::generateRandomExpression(255),
                'idPerfil' => ''
            )
        );
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($parameter);
        $this->dispatch('/perfil/add');
        $this->assertResponseStatusCode(302);
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::editAction()
     */
    public function editActionGet()
    {
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->beginTransaction();
        $serviceManager = Bootstrap::getServiceManager();
        $servicePerfil = $serviceManager->get('Perfil\Service\Perfil');
        $perfil = $servicePerfil->save(
            array(
                'noPerfil' => String::generateRandomExpression(255),
                'dsPerfil' => String::generateRandomExpression(255),
                'idPerfil' => ''
            )
        );
        $this->routeMatch->setParam('action', 'edit');
        $this->routeMatch->setParam('idPerfil', $perfil->getIdPerfil());
        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $arrVariables = $result->getVariables();
        $this->assertTrue(isset($arrVariables['form']));
        $this->assertInstanceOf('Perfil\Form\ManterPerfil', $arrVariables['form']);
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->rollback();;
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::editAction()
     * @depends editActionGet
     */
    public function editActionPost()
    {
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->beginTransaction();
        $serviceManager = Bootstrap::getServiceManager();
        $servicePerfil = $serviceManager->get('Perfil\Service\Perfil');
        $perfil = $servicePerfil->save(
            array(
                'noPerfil' => String::generateRandomExpression(255),
                'dsPerfil' => String::generateRandomExpression(255),
                'idPerfil' => ''
            )
        );
        $parameter = new Parameters(
            array(
                'noPerfil' => $perfil->getNoPerfil(),
                'dsPerfil' => $perfil->getDsPerfil(),
                'idPerfil' => $perfil->getIdPerfil()
            )
        );
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($parameter);
        $this->dispatch('/perfil/edit');
        $this->assertResponseStatusCode(302);
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->rollback();;
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::ajaxListagemAction()
     */
    public function ajaxListagemActionReturnView()
    {
        $this->dispatch('/perfil/ajaxListagem');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Perfil');
        $this->assertControllerName('Perfil\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('perfil');
        $this->assertActionName('ajaxListagem');
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::ajaxAlterarSituacaoAction()
     */
    public function ajaxAlterarSituacaoReturnView()
    {
        $this->dispatch('/perfil/ajaxAlterarSituacao');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Perfil');
        $this->assertControllerName('Perfil\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('perfil');
        $this->assertActionName('ajaxAlterarSituacao');
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::ajaxAlterarSituacaoAction()
     * @depends addActionPost
     */
    public function ajaxAlterarSituacaoPost()
    {
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->beginTransaction();
        $serviceManager = Bootstrap::getServiceManager();
        $servicePerfil = $serviceManager->get('Perfil\Service\Perfil');
        $perfil = $servicePerfil->save(
            array(
                'noPerfil' => String::generateRandomExpression(255),
                'dsPerfil' => String::generateRandomExpression(255),
                'idPerfil' => ''
            )
        );
        $parameter = new Parameters(array('idPerfil' => $perfil->getIdPerfil()));
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($parameter);
        $this->dispatch('/perfil/ajaxAlterarSituacao');
        $this->assertResponseStatusCode(200);
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->rollback();
    }

    /**
     * @test
     * @covers \Perfil\Controller\IndexController::ajaxAlterarSituacaoAction()
     * @depends addActionPost
     */
    public function ajaxAlterarSituacaoPostError()
    {
        $parameter = new Parameters(array('idPerfil' => date('Ymd')));
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($parameter);
        $this->dispatch('/perfil/ajaxAlterarSituacao');
        $this->assertResponseStatusCode(200);
    }
}
