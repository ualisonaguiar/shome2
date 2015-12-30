<?php

namespace SecuriryTest\Controller;

use PHPUnit_Framework_TestCase;
use FinancasTest\Bootstrap;
use Authentication\Message\Message;
use CoreZend\Util\String;
use CoreZend\Util\GenerateTest;
use Authentication\Service\Authentication as AuthenticationService;

class AuthenticationTest extends PHPUnit_Framework_TestCase
{
    use Message;

    public static $pessoaFisica = null;


    protected function setUp()
    {
        parent::setUp();
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->beginTransaction();
    }

    /**
     * @test
     * @covers \Authentication\Service\Authentication::__construct()
     */
    public function construct()
    {
        $serviceAutentication = new AuthenticationService(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager'));
        $this->assertInstanceOf('Authentication\Service\Authentication', $serviceAutentication);
    }

    /**
     * @test
     * @covers \Authentication\Service\Authentication::login()
     */
    public function login()
    {
        $this->preapareDataTable();
        $arrData = array(
            'dsUsuario' => 'teste',
            'dsPassword' => 12345
        );
        $this->assertTrue($this->getServiceAuthentication()->login($arrData));
    }

    /**
     * @test
     * @dataProvider getListLogin
     * @covers \Authentication\Service\Authentication::login()
     * @covers \Authentication\Service\Authentication::getTypeErroAuthentication()
     *
     * @param type $strUsuario
     * @param type $strPassword
     * @param type $strMessage
     */
    public function login1($strUsuario, $strPassword, $strMessage)
    {
        $this->preapareDataTable();
        $arrData = array(
            'dsUsuario' => $strUsuario,
            'dsPassword' => $strPassword
        );
        try {
            $this->getServiceAuthentication()->login($arrData);
        } catch (\Exception $exception) {
            $this->assertSame($strMessage, $exception->getMessage());
        }
    }

    /**
     * @test
     * @dataProvider getListLoginCorrect
     * @covers \Authentication\Service\Authentication::save()
     */
    public function cadastroLogin($intIdPessoaFisica, $strDsLogin, $strPassword)
    {
        $this->getServiceAuthentication()->save(
            array(
                'dsLogin' => $strDsLogin,
                'dsPassword' => $strPassword,
                'idPessoaFisica' => $intIdPessoaFisica
            )
        );
        $arrLogin = $this->getServiceAuthentication()->findBy(
            array(
                'dsLogin' => $strDsLogin,
                'dsPassword' => md5($strPassword),
                'idPessoaFisica' => $intIdPessoaFisica
            )
        );
        $this->assertCount(1, $arrLogin);
        $login = reset($arrLogin);
        $this->assertSame($login->getDsLogin(), $strDsLogin);
        $this->assertSame($login->getDsPassword(), md5($strPassword));
        $this->assertInstanceOf('Application\Entity\PessoaFisica', $login->getIdPessoaFisica());
        $this->assertSame($login->getIdPessoaFisica()->getIdPessoaFisica(), $intIdPessoaFisica);
    }

    /**
     * @test
     * @dataProvider getListLoginCorrect
     * @covers \Authentication\Service\Authentication::save()
     */
    public function cadastroLoginAuthentication($intIdPessoaFisica, $strDsLogin, $strPassword)
    {
        $this->getServiceAuthentication()->save(
            array(
                'dsLogin' => $strDsLogin,
                'dsPassword' => $strPassword,
                'idPessoaFisica' => $intIdPessoaFisica
            )
        );
        $arrData = array(
            'dsUsuario' => $strDsLogin,
            'dsPassword' => $strPassword
        );
        $this->assertTrue($this->getServiceAuthentication()->login($arrData));
    }


    /**
     * @test
     * @dataProvider getListLoginCorrect
     * @covers \Authentication\Service\Authentication::save()
     */
    public function updateLoginAuthentication($intIdPessoaFisica, $strDsLogin, $strPassword)
    {
        $login = $this->preapareDataTable();
        $this->getServiceAuthentication()->save(
            array(
                'dsLogin' => $strDsLogin,
                'dsPassword' => $strPassword,
                'idPessoaFisica' => $intIdPessoaFisica,
                'idLogin' => $login->getIdLogin()
            )
        );
        $arrData = array(
            'dsUsuario' => $strDsLogin,
            'dsPassword' => $strPassword
        );
        $this->assertTrue($this->getServiceAuthentication()->login($arrData));
    }


    /**
     * @test
     * @dataProvider getListLoginCorrect
     * @covers \Authentication\Service\Authentication::save()
     */
    public function upadateLogin($intIdPessoaFisica, $strDsLogin, $strPassword)
    {
        $login = $this->preapareDataTable();
        $this->getServiceAuthentication()->save(
            array(
                'dsLogin' => $strDsLogin,
                'dsPassword' => $strPassword,
                'idPessoaFisica' => $intIdPessoaFisica,
                'idLogin' => $login->getIdLogin()
            )
        );
        $arrLogin = $this->getServiceAuthentication()->findBy(
            array(
                'dsLogin' => $strDsLogin,
                'dsPassword' => md5($strPassword),
                'idPessoaFisica' => $intIdPessoaFisica
            )
        );
        $this->assertCount(1, $arrLogin);
        $login = reset($arrLogin);
        $this->assertSame($login->getDsLogin(), $strDsLogin);
        $this->assertSame($login->getDsPassword(), md5($strPassword));
        $this->assertInstanceOf('Application\Entity\PessoaFisica', $login->getIdPessoaFisica());
        $this->assertSame($login->getIdPessoaFisica()->getIdPessoaFisica(), $intIdPessoaFisica);
    }

    /**
     * @test
     * @covers \Authentication\Service\Authentication::getTextCadastroLogin()
     */
    public function getTextCadastroLogin()
    {
        $strNome = String::generateRandomExpression(10);
        $strUser = String::generateRandomExpression(5);
        $strPassword = String::generateRandomExpression(20);
        $strTexto = $this->getServiceAuthentication()
            ->getTextCadastroLogin($strNome, $strUser, $strPassword);

        $this->assertRegExp('/' . $strNome . '/', $strTexto);
        $this->assertRegExp('/' . $strUser . '/', $strTexto);
        $this->assertRegExp('/' . $strPassword . '/', $strTexto);
    }

    /**
     * @test
     * @covers \Authentication\Service\Authentication::getTxReenvioSenha()
     */
    public function getTxReenvioSenha()
    {
        $strNome = String::generateRandomExpression(10);
        $strUser = String::generateRandomExpression(5);
        $strPassword = String::generateRandomExpression(20);
        $strTexto = $this->getServiceAuthentication()
            ->getTxReenvioSenha($strNome, $strUser, $strPassword);

        $this->assertRegExp('/' . $strNome . '/', $strTexto);
        $this->assertRegExp('/' . $strUser . '/', $strTexto);
        $this->assertRegExp('/' . $strPassword . '/', $strTexto);
    }

    /**
     * @test
     * @covers \Authentication\Service\Authentication::alterarSenha()
     */
    public function alterarSenha()
    {
        $arrDataPessoa = array(
            'dsEmail' => String::generateRandomExpression(11),
            'dsNome' => String::generateRandomExpression(11),
            'dsCpf' => String::generateRandomExpression(11),
            'datAniversario' => date('d/m/Y'),
            'dsLogin' => String::generateRandomExpression(10),
            'idPessoaFisica' => null
        );
        $serviceManager = Bootstrap::getServiceManager();
        $pessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica')
            ->save($arrDataPessoa);
        $strNovaSenha = String::generateRandomExpression(10);
        $login = $this->getServiceAuthentication()
            ->alterarSenha(
                $pessoaFisica->getIdPessoaFisica(),
                $strNovaSenha
            );
        $this->assertInstanceOf('Application\Entity\Login', $login);
        $this->assertSame(md5($strNovaSenha), $login->getDsPassword());
    }

    /**
     * @test
     * @covers \Authentication\Service\Authentication::alterarSenha()
     */
    public function alterarSenha1()
    {
        $arrDataPessoa = array(
            'dsEmail' => String::generateRandomExpression(11),
            'dsNome' => String::generateRandomExpression(11),
            'dsCpf' => String::generateRandomExpression(11),
            'datAniversario' => date('d/m/Y'),
            'dsLogin' => null,
            'idPessoaFisica' => null
        );
        $serviceManager = Bootstrap::getServiceManager();
        $pessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica')
            ->save($arrDataPessoa);
        $strNovaSenha = String::generateRandomExpression(10);
        try {
            $this->getServiceAuthentication()->alterarSenha(
                $pessoaFisica->getIdPessoaFisica(),
                $strNovaSenha
            );
        } catch (\Exception $exeception) {
            $this->assertSame($this->strMsgError03, $exeception->getMessage());
        }
    }

    /**
     *
     * @return type
     */
    public function getListLoginCorrect()
    {
        $pessoaFisica = $this->getCadastroPessoaFisica();
        $intIdPessoaFisica = $pessoaFisica->getIdPessoaFisica();
        return array(
            array(
                'idPessoaFisica' => $intIdPessoaFisica,
                'dsLogin' => String::generateRandomExpression(100),
                'dsPassword' => str_repeat(round(1, 9), 36) . date('YmdHis')
            ),
            array(
                'idPessoaFisica' => $intIdPessoaFisica,
                'dsLogin' => String::generateRandomExpression(100),
                'dsPassword' => str_repeat(round(1, 9), 36) . date('Ymd')
            ),
            array(
                'idPessoaFisica' => $intIdPessoaFisica,
                'dsLogin' => String::generateRandomExpression(100),
                'dsPassword' => str_repeat(round(1, 9), 36) . date('His')
            ),
            array(
                'idPessoaFisica' => $intIdPessoaFisica,
                'dsLogin' => String::generateRandomExpression(100),
                'dsPassword' => str_repeat(round(1, 9), 50)
            ),
        );
    }

    public function getListLogin()
    {
        return array(
            array('Teste 1231', str_repeat(round(1, 10), 10), $this->strMsgError03),
            array('teste', str_repeat(round(1, 10), 10), $this->strMsgError04),
        );
    }

    protected function tearDown()
    {
        Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')->getConnection()->rollback();
        parent::tearDown();
    }

    protected function preapareDataTable()
    {
        $pessoaFisica = $this->getCadastroPessoaFisica();
        $login = $this->getServiceAuthentication()
            ->save(
                array(
                    'idPessoaFisica' => $pessoaFisica->getIdPessoaFisica(),
                    'dsLogin' => 'teste',
                    'dsPassword' => 12345
                )
            );
        return $login;
    }

    protected function getCadastroPessoaFisica()
    {
        if (self::$pessoaFisica) {
            return self::$pessoaFisica;
        }
        $serviceManager = Bootstrap::getServiceManager();
        $strEmail = String::generateRandomExpression(10) . '@gmail.com';
        $pessoaFisica = $serviceManager->get('Pessoa\Service\PessoaFisica')
            ->save(
                array(
                    'dsEmail' => $strEmail,
                    'dsNome' => String::generateRandomExpression(255),
                    'dsCpf' => GenerateTest::cpfRandom(),
                    'dsLogin' => null,
                    'datAniversario' => date('d/m/Y'),
                    'idPessoaFisica' => null
                )
            );
        self::$pessoaFisica = $pessoaFisica;
        return self::$pessoaFisica;
    }

    private function getServiceAuthentication()
    {
        $serviceManager = Bootstrap::getServiceManager();
        return $serviceManager->get('Authentication\Service\Authentication');
    }
}
