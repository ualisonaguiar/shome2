<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreZend\Controller;

use CoreZend\Controller\AbstractController;
use CoreZend\View\Helper\RenderTemplateTrait;

/**
 * Description of AbstractCrudController
 *
 * @author ualison
 */
class AbstractCrudController extends AbstractController
{
    protected $form;

    use RenderTemplateTrait;

    public function __construct($strNamespaceClass)
    {
        $this->service = str_replace('Controller', 'Service', $strNamespaceClass);
    }

    public function saveDataAfterSubmit($strMethod, $strRoute, $strMessages = null, $arrDataForm = null)
    {
        return $this->controlAfterSubmit(
            $this->getForm($arrDataForm),
            $this->service,
            $strMethod,
            $strRoute,
            $strMessages
        );
    }

    protected function getForm($arrDataForm = null)
    {
        $form = new $this->form;
        $form->prepareElementForm();
        if ($arrDataForm) {
            $form->setData($arrDataForm);
        }
        return $form;
    }

    protected function ajaxListagem($form, $strPartial)
    {
        $request = $this->getRequest();
        $strHtml = '';
        if ($request->isPost()) {
            $form->setData($request->getPost()->toArray());
            if ($form->isValid()) {
                $arrRegistro = $this->getService()->getListagem($form->getData());
                $strHtml = $this->renderTemplatePath($strPartial, $arrRegistro);
            }
        }
        return $this->getResponse()->setContent($strHtml);
    }
}
