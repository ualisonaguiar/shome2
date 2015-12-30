<?php

namespace CoreZend\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class FilterValidator extends InputFilter
{
    protected function addFilter(
        $strName,
        $strLabel = null,
        $booRequired = false,
        $strMessage = null,
        $arrValidators = array()
    ) {
        $arrValidator = array(
            array(
                'name' => 'NotEmpty',
                'options' => array(
                    'messages' => array(
                        NotEmpty::IS_EMPTY => ($strMessage)
                            ? $strMessage : 'Campo: ' . $strLabel . ' obrigatório.'
                    )
                )
            )
        );

        $this->add(
            array(
                'name' => $strName,
                'required' => $booRequired,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array_merge($arrValidator, $arrValidators)
            )
        );
    }


    protected function filterStringLength($intMax, $strMessage = null)
    {
        if (is_null($strMessage)) {
            $strMessage = 'Tamanho de caracteres informado passou do limite estabelecido';
        }
        return array(
            'name' => 'StringLength',
            'options' => array(
                'encoding' => 'UTF-8',
                'max' => $intMax,
                'message' => array('stringLengthTooLong' => $strMessage)
            )
        );
    }
}
