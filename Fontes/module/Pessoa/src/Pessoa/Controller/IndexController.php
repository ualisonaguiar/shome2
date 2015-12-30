<?php

namespace Pessoa\Controller;

use CoreZend\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use CoreZend\Util\Format;
use Pessoa\Form\Listagem as ListagemPessoa;
use Pessoa\Form\ManterPessoa as ManterPessoaForm;

class IndexController extends AbstractCrudController
{

    public function __construct()
    {
        parent::__construct(__NAMESPACE__);
        $this->form = 'Pessoa\Form\ManterPessoa';
        $this->service = 'Pessoa\Service\PessoaFisica';
    }

    public function indexAction()
    {
        $form = new ListagemPessoa();
        $form->prepareElementForm();
        return new ViewModel(array('form' => $form));
    }

    /**
     * @auth no
     * @return type
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $form = new ManterPessoaForm();
        $form->prepareElementForm(false);
        if ($request->isPost()) {
            $form->setData($request->getPost()->toArray());
        }
        return $this->controlAfterSubmit(
            $form,
            $this->service,
            'save',
            'pessoa',
            'Pessoa cadastrada com sucesso.'
        );
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $form = new ManterPessoaForm();
        $form->prepareElementForm(true);
        if ($request->isPost()) {
            $form->setData($request->getPost()->toArray());
        } else {
            $arrData = $this->getService()->getInformation(
                $this->getEvent()->getRouteMatch()->getParam('idPessoaFisica')
            );
            $form->setData($arrData);
        }
        return $this->controlAfterSubmit(
            $form,
            $this->service,
            'save',
            'pessoa',
            'Pessoa alterada com sucesso.'
        );
    }

    public function ajaxCheckInformationAction()
    {
        $request = $this->getRequest();
        $booValidate = false;
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            if (array_key_exists('dsCpf', $arrData)) {
                $arrData['dsCpf'] = Format::clearCpfCnpj($arrData['dsCpf']);
            }
            $booValidate = $this->getService()->validateInformacao($arrData);
        }
        return new JsonModel(['status' => $booValidate]);
    }

    public function ajaxListagemAction()
    {
        $form = new ListagemPessoa();
        $form->prepareElementForm();
        return $this->ajaxListagem($form, 'Pessoa/view/_partial/listagem.phtml');
    }

    public function ajaxReenvioSenhaAction()
    {
        try {
            $request = $this->getRequest();
            $arrData = $request->getPost()->toArray();
            $this->getService()->reenvioSenha($arrData['idPessoaFisica']);
            return new JsonModel(['status' => true, 'message' => 'Nova senha enviada ao e-mail.']);
        } catch (\Exception $exception) {
            return new JsonModel(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function historicoReenvioAction()
    {
        $intIdPessoaFisica = $this->getEvent()->getRouteMatch()->getParam('idPessoaFisica');
        $arrHistorico = $this->getService('Pessoa\Service\LogMensageriaPessoaFisica')
            ->findBy(
                array('idPessoaFisica' => $intIdPessoaFisica),
                array('idLogMensageriaPessoaFisica' => 'desc')
            );
        return new ViewModel(array('arrResultHist' => $arrHistorico));
    }
}
