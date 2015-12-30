<?php

namespace PessoaTest\Service;

use PHPUnit_Framework_TestCase;
use FinancasTest\Bootstrap;
use Pessoa\Service\LogMensageriaPessoaFisica as LogMensageriaPessoaFisicaService;

class LogMensageriaPessoaFisicaTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->beginTransaction();
    }

    /**
     * @test
     * @covers \Pessoa\Service\LogMensageriaPessoaFisica::__construct()
     */
    public function construct()
    {
        $serviceAutentication = new LogMensageriaPessoaFisicaService(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager'));
        $this->assertInstanceOf('Pessoa\Service\LogMensageriaPessoaFisica', $serviceAutentication);
    }

    /**
     *
     * @return type
     */
    private function getServiceLogMensageria()
    {
        $serviceManager = Bootstrap::getServiceManager();
        return $serviceManager->get('Pessoa\Service\LogMensageriaPessoaFisica');
    }

    protected function tearDown()
    {
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->rollback();
        parent::tearDown();
    }
}
