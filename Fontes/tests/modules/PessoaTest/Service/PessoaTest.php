<?php

namespace PessoaTest\Service;

use PHPUnit_Framework_TestCase;
use FinancasTest\Bootstrap;
use CoreZend\Util\String;
use CoreZend\Util\GenerateTest;
use Pessoa\Service\PessoaFisica as PessoaFisicaService;
use Pessoa\Message\Message;
use Application\Entity\ConfiguracaoEmail as ConfiguracaoEmailEntity;

class PessoaTest extends PHPUnit_Framework_TestCase
{
    use Message;

    public function setUp()
    {
        parent::setUp();
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->beginTransaction();
    }

    /**
     * @test
     */
    public function getInstaceService()
    {
        $pessoaFisica = new PessoaFisicaService(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager'));
        $this->assertInstanceOf('Pessoa\Service\PessoaFisica', $pessoaFisica);
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::save()
     * @covers \Pessoa\Service\PessoaFisica::preSave()
     * @covers \Pessoa\Service\PessoaFisica::posSave()
     */
    public function save($arrDataPessoa)
    {
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $this->assertInstanceOf('Application\Entity\PessoaFisica', $pessoaFisica);
        $this->assertSame($arrDataPessoa['dsEmail'], $pessoaFisica->getDsEmail());
        $this->assertSame($arrDataPessoa['dsNome'], $pessoaFisica->getDsNome());
        $this->assertSame($arrDataPessoa['dsCpf'], $pessoaFisica->getDsCpf());
        $this->assertSame($arrDataPessoa['datAniversario'], $pessoaFisica->getDatAniversario());
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::save()
     * @covers \Pessoa\Service\PessoaFisica::preSave()
     * @covers \Pessoa\Service\PessoaFisica::posSave()
     */
    public function save1($arrDataPessoa)
    {
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $arrDataPessoa = $this->getDadosPessoaValido();
        $arrDataPessoa = $arrDataPessoa[0][0];
        $arrDataPessoa['idPessoaFisica'] = $pessoaFisica->getIdPessoaFisica();
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $this->assertSame($arrDataPessoa['dsEmail'], $pessoaFisica->getDsEmail());
        $this->assertSame($arrDataPessoa['dsNome'], $pessoaFisica->getDsNome());
        $this->assertSame($arrDataPessoa['dsCpf'], $pessoaFisica->getDsCpf());
        $this->assertSame($arrDataPessoa['datAniversario'], $pessoaFisica->getDatAniversario());
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::preSave()
     * @covers \Pessoa\Service\PessoaFisica::save()
     * @covers \Pessoa\Service\PessoaFisica::posSave()
     */
    public function save2($arrDataPessoa)
    {
        try {
            $this->getServicePessoa()->save($arrDataPessoa);
            $this->getServicePessoa()->save($arrDataPessoa);
        } catch (\Exception $exception) {
            $this->assertSame('CPF já cadastrado.', $exception->getMessage());
        }
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::preSave()
     * @covers \Pessoa\Service\PessoaFisica::save()
     *
     * @expectedException \Exception
     * @expectedExceptionMessage E-mail já cadastrado
     */
    public function save3($arrDataPessoa)
    {
        $this->getServicePessoa()->save($arrDataPessoa);
        $arrDataPessoa['dsCpf'] = GenerateTest::cpfRandom();
        $this->getServicePessoa()->save($arrDataPessoa);
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::save()
     * @covers \Pessoa\Service\PessoaFisica::posSave()
     */
    public function save4($arrDataPessoa)
    {
        $arrDataPessoa['dsLogin'] = '';
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $this->assertInstanceOf('Application\Entity\PessoaFisica', $pessoaFisica);
    }

    /**
     * @test
     * @depends save
     * @covers \Pessoa\Service\PessoaFisica::validateInformacao()
     */
    public function validateInformacao()
    {
        $arrPessoaFisica = $this->getServicePessoa()->findBy();
        $arrData = array(
            'dsCpf' => $arrPessoaFisica[0]->getDsCpf(),
            'dsEmail' => $arrPessoaFisica[0]->getDsEmail(),
        );
        $booReturn = $this->getServicePessoa()->validateInformacao($arrData);
        $this->assertTrue($booReturn);
    }

    /**
     * @test
     * @depends save
     * @covers \Pessoa\Service\PessoaFisica::validateInformacao()
     */
    public function validateInformacao1()
    {
        $this->assertFalse($this->getServicePessoa()->validateInformacao(array()));
    }

    /**
     * @test
     * @depends save
     * @covers \Pessoa\Service\PessoaFisica::validateInformacao()
     */
    public function validateInformacao2()
    {
        $arrData = array('dsCpf' => GenerateTest::cpfRandom());
        $booReturn = $this->getServicePessoa()->validateInformacao($arrData);
        $this->assertFalse($booReturn);

        $arrData = array('dsEmail' => String::generateRandomExpression(5) . '@teste');
        $booReturn = $this->getServicePessoa()->validateInformacao($arrData);
        $this->assertFalse($booReturn);
    }

    /**
     * @test
     * @depends save
     * @covers \Pessoa\Service\PessoaFisica::validateInformacao()
     */
    public function validateInformacao3()
    {
        $arrPessoaFisica = $this->getServicePessoa()->findBy();
        $arrData = array(
            'dsCpf' => $arrPessoaFisica[0]->getDsCpf(),
            'dsEmail' => $arrPessoaFisica[0]->getDsEmail(),
            'idPessoaFisica' => $arrPessoaFisica[1]->getIdPessoaFisica()
        );
        $booReturn = $this->getServicePessoa()->validateInformacao($arrData);
        $this->assertFalse($booReturn);
    }

    /**
     * @test
     * @depends save
     * @covers \Pessoa\Service\PessoaFisica::validateInformacao()
     */
    public function validateInformacao4()
    {
        $arrPessoaFisica = $this->getServicePessoa()->findBy();
        $arrData = array(
            'dsCpf' => $arrPessoaFisica[0]->getDsCpf(),
            'dsEmail' => $arrPessoaFisica[0]->getDsEmail(),
            'idPessoaFisica' => $arrPessoaFisica[0]->getIdPessoaFisica()
        );
        $booReturn = $this->getServicePessoa()->validateInformacao($arrData);
        $this->assertTrue($booReturn);
    }

    /**
     * @test
     * @dataProvider getDadosFiltragemProvideValido
     * @covers \Pessoa\Service\PessoaFisica::getListagem()
     */
    public function getListagem($arrDataProvide)
    {
        $arrPessoaFisicaList = $this->getServicePessoa()->getListagem($arrDataProvide);
        $this->assertSame(1, $arrPessoaFisicaList['qtdRegister']);
        foreach ($arrPessoaFisicaList['register'] as $arrRegister) {
            $this->assertSame($arrDataProvide['dsLogin'], $arrRegister['dsLogin']);
            $this->assertSame($arrDataProvide['dsNome'], $arrRegister[0]->getDsNome());
            $this->assertSame($arrDataProvide['dsCpf'], $arrRegister[0]->getDsCpf());
            $this->assertSame($arrDataProvide['dsEmail'], $arrRegister[0]->getDsEmail());
        }
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::getInformation()
     */
    public function getInformation($arrDataPessoa)
    {
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $intIdPessoaFisica = $pessoaFisica->getIdPessoaFisica();
        $arrGetInformation = $this->getServicePessoa()->getInformation($intIdPessoaFisica);
        $serviceManager = Bootstrap::getServiceManager();
        $arrLogin = $serviceManager->get('Authentication\Service\Authentication')
            ->findBy(array('idPessoaFisica' => $intIdPessoaFisica));
        $this->assertSame($intIdPessoaFisica, $arrGetInformation['idPessoaFisica']);
        $this->assertSame($pessoaFisica->getDsNome(), $arrGetInformation['dsNome']);
        $this->assertSame($pessoaFisica->getDsEmail(), $arrGetInformation['dsEmail']);
        $this->assertSame($pessoaFisica->getDsCpf(), $arrGetInformation['dsCpf']);
        $this->assertSame($pessoaFisica->getDatAniversario(), $arrGetInformation['datAniversario']);
        $this->assertSame($arrLogin[0]->getDsLogin(), $arrGetInformation['dsLogin']);
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::getInformation()
     */
    public function getInformation1($arrDataPessoa)
    {
        $arrDataPessoa['dsLogin'] = null;
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $intIdPessoaFisica = $pessoaFisica->getIdPessoaFisica();
        $arrGetInformation = $this->getServicePessoa()->getInformation($intIdPessoaFisica);
        $this->assertSame($intIdPessoaFisica, $arrGetInformation['idPessoaFisica']);
        $this->assertSame($pessoaFisica->getDsNome(), $arrGetInformation['dsNome']);
        $this->assertSame($pessoaFisica->getDsEmail(), $arrGetInformation['dsEmail']);
        $this->assertSame($pessoaFisica->getDsCpf(), $arrGetInformation['dsCpf']);
        $this->assertSame($pessoaFisica->getDatAniversario(), $arrGetInformation['datAniversario']);
    }

    /**
     * @test
     * @covers \Pessoa\Service\PessoaFisica::getInformation()
     */
    public function getInformation2()
    {
        $arrPessoaFisica = $this->getServicePessoa()->findBy(array(), array('idPessoaFisica' => 'desc'), 1);
        $intIdPessoaFisica = ($arrPessoaFisica[0]->getIdPessoaFisica() + 10);
        try {
            $this->getServicePessoa()->getInformation($intIdPessoaFisica);
        } catch (\Exception $exception) {
            $this->assertSame($this->strMsgError10, $exception->getMessage());
        }
    }

    /**
     * @test
     * @covers \Pessoa\Service\PessoaFisica::reenvioSenha()
     * @covers \Pessoa\Service\PessoaFisica::registroEnvioEmail()
     */
    public function reenvioSenha()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $arrLogin = $serviceManager->get('Authentication\Service\Authentication')
            ->findBy(array(), array('idLogin' => 'desc'), 1);
        $intIdPessoaFisica = $arrLogin[0]->getIdPessoaFisica()->getIdPessoaFisica();
        $returnReenvio = $this->getServicePessoa()->reenvioSenha($intIdPessoaFisica);
        $this->assertInstanceOf('Application\Entity\LogMensageriaPessoaFisica', $returnReenvio);
        $this->assertSame($intIdPessoaFisica, $returnReenvio->getIdPessoaFisica()->getIdPessoaFisica());
    }

    /**
     * @test
     * @covers \Pessoa\Service\PessoaFisica::reenvioSenha()
     * @covers \Pessoa\Service\PessoaFisica::registroEnvioEmail()
     * @expectedException \Exception
     * @expectedExceptionMessage Não existe configuração registrada no envio de e-mail
     */
    public function reenvioSenhaFailure()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $arrLogin = $serviceManager->get('Authentication\Service\Authentication')
            ->findBy(array(), array('idLogin' => 'desc'), 1);
        $intIdPessoaFisica = $arrLogin[0]->getIdPessoaFisica()->getIdPessoaFisica();
        $serviceConfiguracaoEmail = $serviceManager->get('Mensageria\Service\ConfiguracaoEmail');
        $arrConfiguracaoEmail = $serviceConfiguracaoEmail->findBy(
            array(
                'inAtivo' => ConfiguracaoEmailEntity::CO_STATUS_ATIVO
            )
        );
        if ($arrConfiguracaoEmail) {
            foreach ($arrConfiguracaoEmail as $configuracaoEmail) {
                $configuracaoEmail->setInAtivo(ConfiguracaoEmailEntity::CO_STATUS_INATIVO);
                Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->persist($configuracaoEmail);
                Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->flush();
            }
        }
        $this->getServicePessoa()->reenvioSenha($intIdPessoaFisica);
    }

    /**
     * @test
     * @dataProvider getDadosPessoaValido
     * @covers \Pessoa\Service\PessoaFisica::reenvioSenha()
     */
    public function reenvioSenha1($arrDataPessoa)
    {
        $arrDataPessoa['dsLogin'] = null;
        $pessoaFisica = $this->getServicePessoa()->save($arrDataPessoa);
        $intIdPessoaFisica = $pessoaFisica->getIdPessoaFisica();
        try {
            $this->getServicePessoa()->reenvioSenha($intIdPessoaFisica);
        } catch (\Exception $excetion) {
            $this->assertSame('Usuário sem acesso ao sistema.', $excetion->getMessage());
        }
    }

    /**
     *
     */
    protected function tearDown()
    {
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->rollback();
        parent::tearDown();
    }

    /**
     *
     * @return type
     */
    public function getDadosFiltragemProvideValido()
    {
        $arrDataPessoaFisca = $this->getDadosPessoaValido();
        $this->getServicePessoa()->save($arrDataPessoaFisca[0][0]);

        $serviceManager = Bootstrap::getServiceManager();
        $serviceLogin = $serviceManager->get('Authentication\Service\Authentication');
        $arrDataLogin = $serviceLogin->findBy(array(), array(), 1);
        $arrDataProvide = array();
        foreach ($arrDataLogin as $intPosicao => $dataLogin) {
            $pessoaFisica = $dataLogin->getIdPessoaFisica()->toArray();
            $arrDataProvide[$intPosicao] = array(
                'dsLogin' => $dataLogin->getDsLogin(),
                'dsNome' => $pessoaFisica['dsNome'],
                'dsCpf' => $pessoaFisica['dsCpf'],
                'dsEmail' => $pessoaFisica['dsEmail'],
            );
        }
        return array($arrDataProvide);
    }

    /**
     *
     * @return type
     */
    public function getDadosPessoaValido()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $serviceConfiguracaoEmail = $serviceManager->get('Mensageria\Service\ConfiguracaoEmail');
        $serviceConfiguracaoEmail->save(
            array(
                'dsComplemento' => String::generateRandomExpression(5),
                'dsEmail' => String::generateRandomExpression(5),
                'dsPassword' => String::generateRandomExpression(5),
                'dsSmtp' => String::generateRandomExpression(5),
                'dsUsuario' => String::generateRandomExpression(5),
            )
        );
        return array(
            array(
                array(
                    'dsEmail' => String::generateRandomExpression(100) . '@gmail.com',
                    'dsNome' => String::generateRandomExpression(255),
                    'dsCpf' => GenerateTest::cpfRandom(),
                    'datAniversario' => date('d/m/Y'),
                    'dsLogin' => GenerateTest::cpfRandom(),
                    'idPessoaFisica' => null
                )
            )
        );
    }

    /**
     *
     * @return type
     */
    private function getServicePessoa()
    {
        $serviceManager = Bootstrap::getServiceManager();
        return $serviceManager->get('Pessoa\Service\PessoaFisica');
    }
}
