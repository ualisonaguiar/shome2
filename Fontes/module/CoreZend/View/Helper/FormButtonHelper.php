<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreZend\View\Helper;

use Zend\Form\View\Helper\FormButton as ZendFormButton;
use CoreZend\Form\Element\Button as ButtonCoreZend;

/**
 * Description of TraitButton
 *
 * @author ualison
 */
class FormButtonHelper extends ZendFormButton
{
    public function render(ButtonCoreZend $element)
    {
        $strIcone = $element->getOption('icon') ? $element->getOption('icon') : '';
        $escape = $this->getEscapeHtmlHelper();
        return $this->openTag($element) . $strIcone . $escape($element->getLabel()) . $this->closeTag();
    }
}
