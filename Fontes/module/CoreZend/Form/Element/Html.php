<?php

namespace CoreZend\Form\Element;

use Zend\Form\Element;

class Html extends Element
{
    protected $attributes = array('type' => 'html',);
    
    public function __construct($strName = null, $strValue = null, $arrOption = array())
    {
        parent::__construct($strName, $arrOption);
        if (!empty($strValue)) {
            $this->setValue($strValue);
        }
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
