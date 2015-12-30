<?php

/**
 * fonts: http://www.w3schools.com/tags/att_input_type.asp
 */

namespace CoreZend\Form;

use CoreZend\Form\Element\Button as ButtonElement;
use CoreZend\Form\Element\Captcha as CaptchaElement;
use CoreZend\Form\Element\File as FileElement;
use CoreZend\Form\Element\Html as HtmlElement;
use CoreZend\Form\Element\Hidden as HiddenElement;
use CoreZend\Form\Element\Password as PasswordElement;
use CoreZend\Form\Element\Radio as RadioElement;
use CoreZend\Form\Element\Select as SelectElement;
use CoreZend\Form\Element\Text as TextElement;
use CoreZend\Form\Element\Textarea as TextareaElement;
use CoreZend\Captcha\Image as CaptchaImage;
use Zend\Form\Element as ElementZend;

trait InputElementTrait
{

    private $arrParamDefault = array(
        'strName' => 'name',
        'strValue' => 'value',
        'strId' => 'id',
        'strLabel' => 'label',
        'strPlaceHolder' => 'placeholder',
        'booRequired' => 'required',
        'strTitle' => 'title',
        'strClass' => 'class',
        'strStyle' => 'style',
        'strDisabled' => 'disabled',
        'arrAttributes' => 'attributes',
        'arrOptions' => 'options',
        'isTranslate' => 'isTranslate',
        'strType' => 'type'
    );

    /**
     *
     * @param type $strName
     * @param type $arrAttributes
     * @param type $arrOptions
     */
    public function addButton($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new ButtonElement())));
    }

    /**
     *
     * @param type $strName
     * @param type $strLabel
     * @param type $arrMessages
     * @param type $strValue
     * @param type $arrAttributes
     * @param type $arrOptions
     * @return boolean
     */
    public function addCaptcha(
        $strName,
        $strLabel = null
    ) {
        $arrElement = $this->getElementDefault(func_get_args());
        if (!is_array($arrElement)) {
            return false;
        }
        extract($arrElement);
        if (!is_dir('./public/captcha')) {
            mkdir('./public/captcha', 0755, true);
        }
        $captchaImage = new CaptchaImage(
            array(
                'font' => './public/fonts/arial.ttf',
                'width' => 250,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3
            )
        );
        $captchaImage->setImgDir('./public/captcha')
                ->setImgUrl('captcha');
        $captcha = new CaptchaElement();
        $captcha->setCaptcha($captchaImage)
                ->setLabel($strLabel)
                ->setName($strName);
        $this->add($captcha);
    }

    /**
     *
     * @param type $strName
     * @param type $arrAttributes
     * @param type $arrOptions
     */
    public function addCheckbox($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add(array(
            'type' => 'CoreZend\Form\Element\Checkbox',
            'name' => $strName,
            'attributes' => $arrAttributes,
            'options' => $arrOptions,
        ));
    }

    public function addMultiCheckbox($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add(array(
            'name' => $strName,
            'type' => 'CoreZend\Form\Element\MultiCheckbox',
            'attributes' => $arrAttributes,
            'options' => $arrOptions,
        ));
    }

    public function addFile($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new FileElement())));
    }

    public function addHtml($strValue = null)
    {
        $this->add(new HtmlElement(__FUNCTION__, $strValue));
    }

    public function addHidden($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new HiddenElement())));
    }

    public function addPassword($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new PasswordElement())));
    }

    public function addRadio($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new RadioElement())));
    }

    public function addSelect($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new SelectElement())));
    }

    public function addText($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new TextElement())));
    }

    public function addTextarea($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->add($this->prepareElementDefault($strName, $arrAttributes, $arrOptions, (new TextareaElement())));
    }

    private function getElementDefault($arrParam = array())
    {
        $arrParam = reset($arrParam);
        if ((empty($arrParam)) || (!is_array($arrParam))) {
            return false;
        }
        $arrElement = array();
        $arrElementDefault = array_flip($this->arrParamDefault);
        foreach ($arrParam as $strElementParam => $strValeuParam) {
            $arrElement[$arrElementDefault[$strElementParam]] = $strValeuParam;
        }
        return $arrElement;
    }

    /**
     *
     * @param type $strName
     * @param type $arrAttributes
     * @param type $arrOptions
     * @param ElementZend $objectElement
     * @return ElementZend|boolean
     */
    private function prepareElementDefault($strName, $arrAttributes, $arrOptions, ElementZend $objectElement)
    {
        if (func_num_args() == 1) {
            $arrElement = $this->getElementDefault(func_get_args());
            if (!is_array($arrElement)) {
                return false;
            }
            extract($arrElement);
        } else {
            if (empty($arrAttributes)) {
                $arrAttributes = array();
            }
            if (empty($arrOptions)) {
                $arrOptions = array();
            }
        }
        $objectElement->setName($strName)
                ->setOptions($arrOptions)
                ->setAttributes($arrAttributes);
        return $objectElement;
    }
}
