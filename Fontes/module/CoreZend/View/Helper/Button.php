<?php

namespace CoreZend\View\Helper;

use Zend\Form\View\Helper\AbstractHelper as ZendAbstractHelper;

class Button extends ZendAbstractHelper
{
    public function __invoke()
    {
        echo '<div class="pull-right">';
        return $this;
    }

    /**
     *
     * @param type $strName
     * @param type $strOnclick
     */
    public function addVoltar($strName, $strOnclick = null, $arrConfigRoute = null)
    {
        $this->addButtonGeneric(
            'button',
            $strName,
            'btn-primary',
            'Voltar',
            $strOnclick,
            'fa fa-reply',
            $arrConfigRoute
        );
    }

    /**
     *
     * @param type $strName
     * @param type $strType
     * @param type $strValue
     * @param type $strClass
     * @param type $strOnclick
     */
    public function addCadastro(
        $strName,
        $strType = 'button',
        $strValue = 'Cadastro',
        $strClass = null,
        $strOnclick = null,
        $arrConfigRoute = null
    ) {
        $strType = ($strType) ? $strType : 'button';
        $strValue = ($strValue) ? $strValue : 'Cadastrar';
        $this->addButtonGeneric(
            $strType,
            $strName,
            $strClass . ' btn-success',
            $strValue,
            $strOnclick,
            'fa fa-plus',
            $arrConfigRoute
        );
    }

    public function addExcluir(
        $strName,
        $strType = 'button',
        $strValue = 'Excluir',
        $strClass = null,
        $strOnclick = null
    ) {
        $strValue = ($strValue) ? $strValue : 'Excluir';
        $this->addButtonGeneric(
            $strType,
            $strName,
            $strClass . ' btn-danger',
            $strValue,
            $strOnclick,
            'fa fa-remove'
        );
    }

    public function addPesquisar(
        $strName,
        $strType = 'button',
        $strValue = null,
        $strClass = null,
        $strOnclick = null,
        $booSearchPaginator = false,
        $strNameForm = null,
        $strUrl = null
    ) {
        if ($booSearchPaginator) {
            $strUrl = $this->getView()->url($strUrl);
            $strOnclick .= 'filterPaginator("' . $strNameForm . '")';
        }
        $this->addButtonGeneric(
            $strType,
            $strName,
            $strClass . ' btn-info',
            ($strValue) ? $strValue : 'Pesquisar',
            $strOnclick,
            'fa fa-search'
        );
    }

    public function addLimpar($strName, $strNameForm, $strClass = null)
    {
        $this->addButtonGeneric(
            'button',
            $strName,
            $strClass . ' btn',
            'Limpar',
            'clearValuesFromFieldsForm("' . $strNameForm . '")',
            'fa fa-remove'
        );
    }

    public function addButtonGeneric(
        $strType,
        $strName,
        $strClass,
        $strValue,
        $strOnclick = null,
        $strClassIcons = null,
        $arrConfigRoute = null
    ) {
        $strIcone = '';
        if ($strClassIcons) {
            $strIcone = '<i class="' . $strClassIcons . '"></i>&nbsp;';
        }
        if ($arrConfigRoute) {
            $strUrl = $this->getView()->url(
                $arrConfigRoute[0],
                ((count($arrConfigRoute) != 0) ? $arrConfigRoute[1] : null)
            );
            $strButton = $this->createButtonHipperlink($strName, $strClass, $strValue, $strUrl, $strOnclick, $strIcone);
        } else {
            $strButton = $this->createButton($strType, $strName, $strClass, $strValue, $strOnclick, $strIcone);
        }
        echo $strButton . '&nbsp;&nbsp;</div>';
    }

    private function createButton(
        $strType,
        $strName,
        $strClass,
        $strValue,
        $strOnclick = null,
        $strIcone = null
    ) {
        $strButton = '<button name="' . $strName . '" id="' .
            $strName . '" class="btn ' . $strClass . '" title="' . $strValue .'" ';
        $strButton .= "type='" . $strType . "' ";
        if ($strOnclick) {
            $strButton .= "onclick=' ". $strOnclick . "'";
        }
        $strButton .= '>';
        $strButton .= $strIcone;
        $strButton .= $strValue . '</button>';
        return $strButton;
    }

    private function createButtonHipperlink(
        $strName,
        $strClass,
        $strValue,
        $strUrl,
        $strOnclick = null,
        $strIcone = null
    ) {
        $strButton = '<a id="' . $strName . '" class="btn ' . $strClass . '" title="' . $strValue .'" ';
        if ($strOnclick) {
            $strButton .= "onclick=' ". $strOnclick . "'";
        } else {
            $strButton .= "href=' ". $strUrl . "'";
        }
        $strButton .= '>';
        $strButton .= $strIcone;
        $strButton .= $strValue . '</a>';
        return $strButton;
    }
}
