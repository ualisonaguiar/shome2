<?php

namespace CoreZend\Controller;

trait ControllValidateForm
{
    protected function validateDataForm(&$form, $arrData)
    {
        $form->setData($arrData);
        if (!$form->isValid()) {
            $arrMessagesForm = $form->getMessagesForm();
            foreach ($arrMessagesForm as $strMessage) {
                $this->flashMessenger()->addMessage(array('danger' => array($strMessage)));
            }
            return false;
        }
        return true;
    }
}
