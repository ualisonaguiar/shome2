<?php

namespace CoreZend\Form;

trait InputElementSpecificTrait
{
    public function addDate($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['class'] = (array_key_exists('class', $arrAttributes))
            ? $arrAttributes['class'] . ' data-single' : 'data-single';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addCep($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['class'] = (array_key_exists('class', $arrAttributes))
            ? $arrAttributes['class'] . ' cep-single' : 'cep-single';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addNumeric($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['onkeypress'] = 'return SomenteNumero(event);';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addCpf($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['class'] = (array_key_exists('class', $arrAttributes))
            ? $arrAttributes['class'] . ' mask-cpf' : 'mask-cpf';
        $arrAttributes['onchange'] = 'return checkValue(this.value, "cpf", true, this);';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addCnpj($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['class'] = (array_key_exists('class', $arrAttributes))
            ? $arrAttributes['class'] . ' mask-cnpj' : 'mask-cnpj';
        $arrAttributes['onchange'] = 'return checkValue(this.value, "cnpj", true, this);';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addEmail($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['onchange'] = 'return checkValue(this.value, "email", true, this);';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addMoney($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $arrAttributes['class'] = (array_key_exists('class', $arrAttributes))
            ? $arrAttributes['class'] . ' mask-money' : 'mask-money';
        return $this->addText($strName, $arrAttributes, $arrOptions);
    }

    public function addInputRadioAtivoInativo($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->addHtml('<div id="btn-group-' . $strName .' " class="btn-group" data-toggle="buttons">');
        $strValueInput = (array_key_exists('value', $arrAttributes) ? $arrAttributes['value'] : '');
        $this->addHtml('<label for="' . $strName .'">' . $arrOptions['label'] .'</label>');
        $this->addHtml('<br />');
        $this->prepareInputRadio($strName, 'Ativo', self::INPUT_RADIO_ATIVO_VALOR, 'success', $strValueInput);
        $this->prepareInputRadio($strName, 'Inativo', self::INPUT_RADIO_INATIVO_VALOR, 'danger', $strValueInput);
        $this->addHtml('<br />');
        $this->addHtml('<br />');
        $this->addHtml('</div>');
    }

    public function addDateRange($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->addHtml('<div class="row">');
        $this->addHtml('<div class="col-md-12"><label for="idPessoaJuridica">'. $arrOptions['label'] .'</label></div>');
        $this->addHtml('</div>');
        unset($arrOptions['label']);
        $this->addHtml('<div class="row">');
        $this->addHtml('<div class="col-md-4">');
        $arrAttributesInicio = $arrAttributes;
        $arrAttributesInicio['id'] = $arrAttributes['id'] . '_Inicio';
        $this->addDate($strName . '_inicio', $arrAttributesInicio, $arrOptions);
        $this->addHtml('</div>');
        $this->addHtml('<div class="col-md-4">');
        $arrAttributesFinal = $arrAttributes;
        $arrAttributesFinal['id'] = $arrAttributes['id'] . '_Inicio';
        $this->addDate($strName . '_final', $arrAttributesFinal, $arrOptions);
        $this->addHtml('</div>');
        $this->addHtml('</div>');
    }

    public function addSugestion($strName, $arrAttributes = array(), $arrOptions = array())
    {
        $this->addText($strName, $arrAttributes, $arrOptions);
        $arrValueSugestion = array();
        $intPosicao = 0;
        foreach ($arrOptions['valueSugestion'] as $intValue => $strValue) {
            $arrValueSugestion[$intPosicao]['label'] = $strValue;
            $arrValueSugestion[$intPosicao]['value'] = $intValue;
            $intPosicao += 1;
        }
        $this->addHtml('
            <script>
                $(function() {
                    $( "#' . $strName .'" ).autocomplete({
                      source: ' . json_encode(array_values($arrValueSugestion)) .',
                      minLength: 3,
                      select: function( event, ui ) {
                        selecioneVinculoConcurso(ui.item.value, ui.item.label);
                        return false;
                      }
                    });
                });
            </script>
        ');
    }

    private function prepareInputRadio($strName, $strLabel, $strValueInput, $strClass, $strValue = null)
    {
        $strBoolChecked = '';
        $strActive = '';
        if ($strValue) {
            if ($strValue == $strValueInput) {
                $strBoolChecked = 'checked';
                $strActive = ' active';
            }
        }
        $this->addHtml('
            <label class="btn btn-' . $strClass . $strActive .'">
              <input type="radio" name="' . $strName . '" id="' . $strName .
            '" autocomplete="off" value="' . $strValueInput .'" ' . $strBoolChecked . '>' . $strLabel. '
            </label>
        ');
    }
}
