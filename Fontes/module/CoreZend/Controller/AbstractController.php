<?php

namespace CoreZend\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use CoreZend\Message\FlashMessenger;

abstract class AbstractController extends AbstractActionController
{
    use ControllValidateForm,
        FlashMessenger;

    protected $service;

    /**
     * Metodo responsavel por realizar a acao apos o submit.
     *
     * @param FormInterface $form
     * @param string $strService
     * @param string $strMethod
     * @param string $strRoute
     * @param array $strMessages
     * @return ViewModel
     */
    protected function controlAfterSubmit(
        FormInterface $form,
        $strService,
        $strMethod,
        $strRoute,
        $strMessages = null
    ) {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $arrData = $request->getPost()->toArray();
            try {
                if ($this->validateDataForm($form, $arrData)) {
                    $this->getService($strService)->$strMethod($form->getData());
                    if ($strMessages) {
                        $this->setMessageSuccess($strMessages);
                    }
                    return $this->redirect()->toRoute($strRoute);
                }
            } catch (\Exception $exception) {
                $this->setMessageError($exception->getMessage());
            }
        }
        return new ViewModel(['form' => $form]);
    }

    /**
     *
     * @param type $strService
     * @return type
     */
    protected function getService($strService = null)
    {
        if (!$strService) {
            $strService = $this->service;
        }
        return $this->getServiceLocator()->get($strService);
    }
}
