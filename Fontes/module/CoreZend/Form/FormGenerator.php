<?php

namespace CoreZend\Form;

use Zend\Form\Form;
use CoreZend\Form\InputElementTrait;
use CoreZend\Form\InputElementSpecificTrait;
use CoreZend\Form\PrepareFormEntity;

class FormGenerator extends Form
{
    use InputElementTrait,
        InputElementSpecificTrait;

    const INPUT_RADIO_ATIVO_VALOR = 1;
    const INPUT_RADIO_INATIVO_VALOR = 2;

    public $serviceLocator = null;

    public function __construct($name = null, $options = array())
    {
        $this->setAttributes(
            array(
                'class' => 'form-validate'
            )
        );
        parent::__construct($name, $options);
    }

    public function getMessagesForm()
    {
        $arrMessagesError = $this->getMessages();
        $arrMessagesErrorForm = array();
        if (count($arrMessagesError) != 0) {
            foreach ($arrMessagesError as $strField => $arrMessageValidator) {
                if (!array_key_exists($strField, $arrMessagesErrorForm)) {
                    foreach ($arrMessageValidator as $mixMessage) {
                        if (is_array($mixMessage)) {
                            $arrMessagesErrorForm[$strField] = reset($mixMessage);
                        } else {
                            $arrMessagesErrorForm[$strField] = $mixMessage;
                        }
                        break;
                    }
                }
            }
        }
        return $arrMessagesErrorForm;
    }
}
