<?php

namespace Pessoa\Service;

use CoreZend\Service\AbstractServiceRepository;
use Application\Entity\PessoaFisica as PessoaFisicaEntity;
use Application\Entity\LogMensageriaPessoaFisica as LogMensageriaPessoaFisicaEntity;
use Pessoa\Message\Message;
use CoreZend\Util\String;
use CoreZend\Util\Date;

class PessoaFisica extends AbstractServiceRepository
{
    use Message;

    public function __construct($entityManager)
    {
        parent::__construct($entityManager, __NAMESPACE__);
        $this->strNameEntity = 'Application\Entity\PessoaFisica';
        $this->strPk = 'idPessoaFisica';
    }

    /**
     * Metodo responsavel por salvar os dados da pessoa fisica
     *
     * @param type $arrData
     * @return PessoaFisicaEntity
     * @throws \Exception
     */
    public function save($arrData)
    {
        try {
            $this->begin();
            $this->preSave($arrData);
            if ($arrData['idPessoaFisica']) {
                $pessoaFisica = $this->find($arrData[$this->strPk]);
            } else {
                $pessoaFisica = new PessoaFisicaEntity();
            }
            $arrData['datAniversario'] = Date::convertDateTemplate($arrData['datAniversario']);
            $pessoaFisica->setDsEmail($arrData['dsEmail'])
                ->setDsNome($arrData['dsNome'])
                ->setDsCpf($arrData['dsCpf'])
                ->setDatAniversario(new \DateTime($arrData['datAniversario']));
            $this->getEntityManager()->persist($pessoaFisica);
            $this->getEntityManager()->flush();
            $this->posSave($arrData, $pessoaFisica);
            $this->commit();
            return $pessoaFisica;
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * metodo responsavel por validar o email
     *
     * @param array $arrData
     */
    public function validateInformacao($arrData)
    {
        if (empty($arrData)) {
            return false;
        }
        $arrMethod = array(
            'dsCpf' => 'findOneByDsCpf',
            'dsEmail' => 'findOneByDsEmail'
        );
        $strMethod = $arrMethod[array_keys($arrData)[0]];
        $strValue = $arrData[array_keys($arrData)[0]];
        $pessoa = $this->getRepositoryEntity()->$strMethod($strValue);
        if (!$pessoa) {
            return false;
        }
        if (array_key_exists($this->strPk, $arrData)) {
            if ($arrData[$this->strPk] != $pessoa->getIdPessoaFisica()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Metodo responsavel por retornar informacoes
     *
     * @param type $intIdPessoaFisica
     * @return array
     */
    public function getInformation($intIdPessoaFisica)
    {
        try {
            $arrLogin = $this->getService('Authentication\Service\Authentication')
                ->findBy(array('idPessoaFisica' => $intIdPessoaFisica));
            if ($arrLogin) {
                $arrDataPessoa = $arrLogin[0]->getIdPessoaFisica()->toArray();
                $arrDataPessoa['dsLogin'] = $arrLogin[0]->getDsLogin();
            } else {
                $pessoaFisica = $this->find($intIdPessoaFisica);
                if (!$pessoaFisica) {
                    throw new \Exception($this->strMsgError10);
                }
                $arrDataPessoa = $pessoaFisica->toArray();
            }
            return $arrDataPessoa;;
        } catch (\Exception $excetpion) {
            throw new \Exception($excetpion->getMessage());
        }
    }

    /**
     * Metodo responsavel pelo reenvio da senha ao usuario.
     *
     * @param type $intIdPessoaFisica
     * @return type
     * @throws \Exception
     */
    public function reenvioSenha($intIdPessoaFisica)
    {
        try {
            $strPassword = String::generateRandomExpression(8, true);
            $arrLogin = $this->getService('Authentication\Service\Authentication')->findBy(
                array('idPessoaFisica' => $intIdPessoaFisica)
            );
            if (!$arrLogin) {
                throw new \Exception('Usuário sem acesso ao sistema.');
            }
            $login = $arrLogin[0];
            $login->setDsPassword(md5($strPassword));
            $this->getEntityManager()->persist($login);
            $this->getEntityManager()->flush();
            $pessoaFisica = $login->getIdPessoaFisica();
            $serviceLogin = $this->getService('Authentication\Service\Authentication');
            $strTexto = $serviceLogin->getTxReenvioSenha(
                $pessoaFisica->getDsNome(),
                $login->getDsLogin(),
                $strPassword
            );
            return $this->registroEnvioEmail($pessoaFisica, 'SHOME2 :: Reenvio Senha', $strTexto);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Metodo responsavel por registar o envio do e-mail da pessoa fisica.
     *
     * @param PessoaFisicaEntity $pessoaFisica
     * @param type $strAssunto
     * @param type $strTexto
     * @return LogMensageriaPessoaFisicaEntity
     * @throws \Exception
     */
    protected function registroEnvioEmail(PessoaFisicaEntity $pessoaFisica, $strAssunto, $strTexto)
    {
        try {
            $this->begin();
            $mensageriaEmail = $this->getService('Mensageria\Service\MensageriaEmail')->registrarEnvio(
                $pessoaFisica->getDsEmail(),
                $pessoaFisica->getDsNome(),
                $strAssunto,
                $strTexto
            );
            $logMensageria = new LogMensageriaPessoaFisicaEntity();
            $logMensageria->setIdMensageriaEmail($mensageriaEmail)
                ->setIdPessoaFisica($pessoaFisica);
            $this->getEntityManager()->persist($logMensageria);
            $this->getEntityManager()->flush();
            $this->commit();
            return $logMensageria;
        } catch (\Exception $exception) {
            $this->rollback();
            throw new \Exception($exception);
        }
    }

    /**
     * Metodo responsavel para realizar operacoes antes de salvar.
     *
     * @param type $arrData
     * @return boolean
     * @throws \Exception
     */
    protected function preSave($arrData)
    {
        $arrUnike = array(
            'dsCpf' => $this->strMsgError07,
            'dsEmail' => $this->strMsgError08
        );
        foreach ($arrUnike as $strFiled => $strMessage) {
            $strMethod = 'findOneBy' . ucfirst($strFiled);
            $usuario = $this->getRepositoryEntity()->$strMethod($arrData[$strFiled]);
            if ($usuario) {
                if ($usuario->getIdPessoaFisica() != $arrData[$this->strPk]) {
                    throw new \Exception($strMessage);
                }
            }
        }
        return true;
    }

    /**
     * Metodo responsavel para realizar operacoes apos de salvar.
     *
     * @param type $arrData
     * @param type $pessoaFisica
     */
    protected function posSave($arrData, PessoaFisicaEntity $pessoaFisica)
    {
        # Salvando informacao do login
        if ($arrData['dsLogin']) {
            $serviceLogin = $this->getService('Authentication\Service\Authentication');
            $arrDataLoginSave = $serviceLogin->findBy(
                array('idPessoaFisica' => $pessoaFisica->getIdPessoaFisica())
            );
            if ($arrDataLoginSave) {
                return $arrDataLoginSave;
            }
            $arrDataLogin = array(
                'dsLogin' => $arrData['dsLogin'],
                'dsPassword' => String::generateRandomExpression(8, true),
                'idPessoaFisica' => $pessoaFisica->getIdPessoaFisica()
            );
            $serviceLogin->save($arrDataLogin);
            $strTexto = $serviceLogin->getTextCadastroLogin(
                $pessoaFisica->getDsNome(),
                $arrDataLogin['dsLogin'],
                $arrDataLogin['dsPassword']
            );
            return $this->registroEnvioEmail($pessoaFisica, 'SHOME2 :: Cadastro de Usuário', $strTexto);
        }
        return false;
    }
}
