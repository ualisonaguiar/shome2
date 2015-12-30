<?php

namespace PessoaTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Pessoa\Controller\IndexController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use CoreZend\Util\GenerateTest;
use CoreZend\Util\String;
use FinancasTest\Bootstrap;
use Zend\Stdlib\Parameters;
use CoreZend\TestUnit\TraitAutentication;

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
        $this->routeMatch = new RouteMatch(array('controller' => 'pessoa'));
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator(Bootstrap::getServiceManager());
        parent::setUp();
        $this->makeLogin();
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::__construct()
     */
    public function construct()
    {
        $this->assertInstanceOf('Pessoa\Controller\IndexController', $this->controller);
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::indexAction()
     */
    public function indexActionCanBeAccessed()
    {
        $this->dispatch('/pessoa');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Pessoa');
        $this->assertControllerName('Pessoa\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('pessoa');
        $this->assertActionName('index');
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::indexAction()
     * @depends indexActionCanBeAccessed
     */
    public function indexActionReturnView()
    {
        $this->routeMatch->setParam('action', 'index');
        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::addAction()
     */
    public function addActionCanBeAccessed()
    {
        $this->dispatch('/pessoa/add');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Pessoa');
        $this->assertControllerName('Pessoa\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('pessoa');
        $this->assertActionName('add');
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::addAction()
     */
    public function addActionReturnView()
    {
        $this->routeMatch->setParam('action', 'add');
        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $arrVariables = $result->getVariables();
        $this->assertTrue(isset($arrVariables['form']));
        $this->assertInstanceOf('Pessoa\Form\ManterPessoa', $arrVariables['form']);
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::addAction()
     */
    public function addActionCanPost()
    {
        $this->routeMatch->setParam('action', 'add');
        $strCpf = GenerateTest::cpfRandom();
        $parameter = new Parameters(
            array(
                'dsNome' => String::generateRandomExpression(255),
                'dsEmail' => 'teste' . date('YmdHis') . 'email@test.com',
                'dsCpf' => $strCpf,
                'datAniversario' => date('d/m/Y'),
                'dsLogin' => String::generateRandomExpression(15)
            )
        );
        $this->request->setMethod('POST')->setPost($parameter);
        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::ajaxCheckInformationAction()
     */
    public function ajaxCheckInformationActionCanBeAccessed()
    {
        $this->dispatch('/pessoa/ajaxCheckInformation');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Pessoa');
        $this->assertControllerName('Pessoa\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('pessoa');
        $this->assertActionName('ajaxCheckInformation');
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::ajaxCheckInformationAction()
     */
    public function ajaxCheckInformationActionReturnView()
    {
        $this->routeMatch->setParam('action', 'ajaxCheckInformation');
        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\JsonModel', $result);
        $arrVariables = $result->getVariables();
        $this->assertArrayHasKey('status', $arrVariables);
    }

    /**

     * @depends ajaxCheckInformationActionReturnView
     * @dataProvider getListInformationInvalid
     * @covers \Pessoa\Controller\IndexController::ajaxCheckInformationAction()
     */
    public function ajaxCheckInformationActionPostInvalid($strCpf, $strEmail)
    {
        $arrTypeTest = array('dsCpf', 'dsEmail');
        foreach ($arrTypeTest as $strTypeField) {
            $strValue = ($strTypeField == 'dsCpf') ? $strCpf : $strEmail;
            $this->routeMatch->setParam('action', 'ajaxCheckInformation');
            $parameter = new Parameters(array($strTypeField => $strValue));
            $this->request->setMethod('POST')->setPost($parameter);
            $result = $this->controller->dispatch($this->request);
            $response = $this->controller->getResponse();
            $this->assertEquals(200, $response->getStatusCode());
            $arrVariables = $result->getVariables();
            $this->assertArrayHasKey('status', $arrVariables);
            $this->assertFalse($arrVariables['status']);
        }
    }

    /**
     * @test
     * @depends ajaxCheckInformationActionReturnView
     * @dataProvider getListInformationValid
     * @covers \Pessoa\Controller\IndexController::ajaxCheckInformationAction()
     */
    public function ajaxCheckInformationActionPostValid($strCpf, $strEmail)
    {
        $arrTypeTest = array('dsCpf', 'dsEmail');
        foreach ($arrTypeTest as $strTypeField) {
            $strValue = ($strTypeField == 'dsCpf') ? $strCpf : $strEmail;
            $this->routeMatch->setParam('action', 'ajaxCheckInformation');
            $parameter = new Parameters(array($strTypeField => $strValue));
            $this->request->setMethod('POST')->setPost($parameter);
            $result = $this->controller->dispatch($this->request);
            $response = $this->controller->getResponse();
            $this->assertEquals(200, $response->getStatusCode());
            $arrVariables = $result->getVariables();
            $this->assertArrayHasKey('status', $arrVariables);
            $this->assertTrue($arrVariables['status']);
        }
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::editAction()
     */
    public function editAction()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $arrPessoaFisica = $servicePessoaFisica->findBy();
        $this->routeMatch->setParam('action', 'edit');
        $this->routeMatch->setParam('idPessoaFisica', $arrPessoaFisica[0]->getIdPessoaFisica());

        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $arrVariables = $result->getVariables();
        $this->assertTrue(isset($arrVariables['form']));
        $this->assertInstanceOf('Pessoa\Form\ManterPessoa', $arrVariables['form']);
    }


    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::editAction()
     */
    public function editActionPost()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $arrPessoaFisica = $servicePessoaFisica->findBy(array(), array(), 1);
        $intIdPessoaFisica = $arrPessoaFisica[0]->getIdPessoaFisica();
        $this->routeMatch->setParam('action', 'edit')
            ->setParam('idPessoaFisica', $intIdPessoaFisica);
        $strCpf = GenerateTest::cpfRandom();
        $strNome = String::generateRandomExpression(255);
        $strEmail = 'teste' . date('YmdHis') . 'email@test.com';
        $parameter = new Parameters(
            array(
                'dsNome' => $strNome,
                'dsEmail' => $strEmail,
                'dsCpf' => $strCpf,
                'datAniversario' => date('d/m/Y'),
                'dsLogin' => String::generateRandomExpression(15),
                'idPessoaFisica' => $intIdPessoaFisica
            )
        );
        $this->request->setMethod('POST')->setPost($parameter);
        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $arrPessoaFisica = $servicePessoaFisica->findBy(array('dsCpf' => $strCpf));
        $this->assertSame($strNome, $arrPessoaFisica[0]->getDsNome());
        $this->assertSame($strCpf, $arrPessoaFisica[0]->getDsCpf());
        $this->assertSame($strEmail, $arrPessoaFisica[0]->getDsEmail());

    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::ajaxListagemAction()
     */
    public function ajaxListagemAction()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $arrPessoaFisica = $servicePessoaFisica->findBy();
        $parameter = new Parameters(array('dsCpf' => $arrPessoaFisica[0]->getDsCpf()));

        $this->routeMatch->setParam('action', 'ajaxListagem');
        $this->request->setMethod('POST')->setPost($parameter);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($result->getContent()));
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::ajaxReenvioSenhaAction()
     */
    public function ajaxReenvioSenhaAction()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $arrPessoaFisica = $servicePessoaFisica->findBy();
        $serviceManager->get('Authentication\Service\Authentication')->save(
            array(
                'idPessoaFisica' => $arrPessoaFisica[0]->getIdPessoaFisica(),
                'dsLogin' => 'teste' . date('YmdHis'),
                'dsPassword' => md5(date('YmdHis'))
            )
        );
        $parameter = new Parameters(array('idPessoaFisica' => $arrPessoaFisica[0]->getIdPessoaFisica()));
        $this->routeMatch->setParam('action', 'ajaxReenvioSenha');
        $this->request->setMethod('POST')->setPost($parameter);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $arrVariables = $result->getVariables();
        $this->assertArrayHasKey('status', $arrVariables);
        $this->assertArrayHasKey('message', $arrVariables);
        $this->assertTrue($arrVariables['status']);
        $this->assertSame('Nova senha enviada ao e-mail.', $arrVariables['message']);
    }

    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::ajaxReenvioSenhaAction()
     */
    public function ajaxReenvioSenhaActionInvalid()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $servicePessoaFisica->save(
            array(
                'idPessoaFisica' => null,
                'dsNome' => 'Test',
                'dsEmail' => date('YmdHis') . 'test@test',
                'dsCpf' => GenerateTest::cpfRandom(),
                'datAniversario' => date('Y-m-d'),
                'dsLogin' => null
            )
        );
        $arrPessoaFisica = $servicePessoaFisica->findBy(array(), array('idPessoaFisica' => 'desc'), 1);
        $parameter = new Parameters(array('idPessoaFisica' => $arrPessoaFisica[0]->getIdPessoaFisica()));
        $this->routeMatch->setParam('action', 'ajaxReenvioSenha');
        $this->request->setMethod('POST')->setPost($parameter);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $arrVariables = $result->getVariables();
        $this->assertArrayHasKey('status', $arrVariables);
        $this->assertArrayHasKey('message', $arrVariables);
        $this->assertFalse($arrVariables['status']);
        $this->assertSame('Usuário sem acesso ao sistema.', $arrVariables['message']);
    }


    /**
     * @test
     * @covers \Pessoa\Controller\IndexController::historicoReenvioAction()
     */
    public function historicoReenvioAction()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $arrPessoaFisica = $servicePessoaFisica->findBy(array(), array(), 1);
        $this->routeMatch->setParam('action', 'historico-reenvio');
        $this->routeMatch->setParam('idPessoaFisica', $arrPessoaFisica[0]->getIdPessoaFisica());
        $result = $this->controller->dispatch($this->request);
        $this->assertResponseStatusCode(200);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function getListInformationValid()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $servicePessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica');
        $arrData = array(
            'dsEmail' => String::generateRandomExpression(100) . '@gmail.com',
            'dsNome' => String::generateRandomExpression(255),
            'dsCpf' => GenerateTest::cpfRandom(),
            'dsLogin' => null,
            'datAniversario' => date('d/m/Y'),
            'idPessoaFisica' => null
        );
        $pessoaFisica = $servicePessoaFisica->save($arrData);
        return array(
            array(
                $pessoaFisica->getDsCpf(),
                $pessoaFisica->getDsEmail()
            )
        );
    }

    public function getListInformationInvalid()
    {
        return array(
            array(
                GenerateTest::cnpjRandom(),
                String::generateRandomExpression(10) . '@gmail.com',
            ),
            array(
                GenerateTest::cnpjRandom(true),
                String::generateRandomExpression(10) . '@gmail.com',
            ),
        );
    }
}
