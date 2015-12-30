<?php

namespace CoreZend\View\Helper;

use Zend\Form\View\Helper\AbstractHelper as ZendAbstractHelper;

class RenderScript extends ZendAbstractHelper
{

    public function __invoke($strFileName)
    {
        if (!empty($strFileName)) {
            $strFileName = $this->getView()->basePath($strFileName);
            if (substr($strFileName, -3) == 'css') {
                echo '<link rel="stylesheet" type="text/css" href="' . $strFileName .'"/>';
            } else {
                echo '<script type="text/javascript" src="' . $strFileName .'"></script>';
            }
        }
    }
}
