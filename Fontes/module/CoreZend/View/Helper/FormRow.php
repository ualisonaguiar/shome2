<?php

namespace CoreZend\View\Helper;

use Zend\Form\View\Helper\FormRow as ZendFormRow;
use Zend\Form\ElementInterface;

class FormRow extends ZendFormRow
{

    public function render(ElementInterface $element)
    {
        if (in_array($element->getAttribute('type'), array('html'))) {
            return $element->getValue();
        }
        return parent::render($element);
    }
}
