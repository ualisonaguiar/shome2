<?php

namespace CoreZend\View\Helper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Model\ViewModel;

/**
 * Description of RenderTemplateTrait
 *
 * @author ualison
 */
trait RenderTemplateTrait
{
    protected function renderTemplatePath($strPath, $arrVariables)
    {
        $view = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap(array('mailTemplate' => __DIR__ . '/../../../' . $strPath));
        $view->setResolver($resolver);
        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailTemplate')->setVariables($arrVariables);
        return $view->render($viewModel);
    }
}
