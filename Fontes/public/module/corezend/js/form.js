/**
 * Retorna qual o formulario algum determinado objeto (elemento) pertence
 *
 * @param OBJECT element
 * @return OBJECT form
 */
function getFormByElement(element)
{
    var form = null;
    var actual = element;
    while ((form == null) && (actual != undefined) && (actual.parentNode != document.body)) {
        actual = actual.parentNode;
        if (actual == undefined)
            break;
        var strTagName = actual.tagName + '';
        if (strTagName.toUpperCase() == 'FORM')
            form = actual;
    }
    return form;
}

/**
 * Verifica se o texto tem o numero de caracteres maior que o definido
 *
 * @param MIX mixElement
 * @param HANDLER event
 * @param INTEGER intLength
 * @param BOOLEAN booOnlyIe
 * @return BOOLEAN
 */
function maxLengthControll(mixElement, intLength, event, booOnlyIe)
{
    if ((mixElement == undefined) || (intLength == undefined))
        return false;
    var element = getObject(mixElement);
    if (element == undefined)
        return false;
    if (booOnlyIe == undefined)
        booOnlyIe = false;
    if ((booOnlyIe) && (!document.all))
        return true;
    var strTextContent = '';
    var arrStructure = new Array('value', 'textContent', 'text');
    for (var intCount = 0; intCount < arrStructure.length; ++intCount) {
        var strStructure = arrStructure[intCount];
        eval('var booStructure = (element.' + strStructure + ');');
        if (booStructure) {
            eval('strTextContent = element.' + strStructure + ';');
            if (strTextContent.length > intLength) {
                eval('element.' + strStructure + ' = strTextContent.substring(0, intLength);');
                return false;
            }
        }
    }
    strTextContent = captureValueFromElement(element);
    if (strTextContent.length < intLength)
        return true;
    if (event != undefined) {
        var strKeyType = getKeyType(getIntKeyCode(event));
        if ((strKeyType == 'position') || (strKeyType == 'Fn') || (strKeyType == 'backspace') || (strKeyType == 'delete') || (strKeyType == 'tab'))
            return true;
    }
    event = false;
    return false;
}

/**
 * Verifica apos 10 milisegundos (devido ao onpaste via mouse) se o texto tem o numero de 
 * caracteres maior que o definido (nao precisa do evento)
 *
 * @param MIX mixElement
 * @param INTEGER intLength
 * @param BOOLEAN booOnlyIe
 * @return BOOLEAN
 */
function maxLengthControllTimeout(mixElement, intLength, booOnlyIe)
{
    if ((mixElement == undefined) || (intLength == undefined))
        return false;
    var element = getObject(mixElement);
    if ((element != undefined) && (element.id != undefined) && (element.id != '')) {
        setTimeout("maxLengthControll('" + element.id + "', " + intLength + ", undefined, " + booOnlyIe + ");", 10);
        return true;
    }
    return false;
}

/**
 * Checa e descheca todos os elementos de um determinado name
 *
 * @param MIX mixElementInvoker
 * @param STRING strElementsName
 * @param STRING strFunctionExec
 * @param BOOLEAN booNotUseDisabled
 * @return BOOLEAN
 */
function checkUncheckFromName(mixElementInvoker, strElementsName, strFunctionExec, booNotUseDisabled)
{
    if ((mixElementInvoker == undefined) || (strElementsName == undefined))
        return false;
    var elementInvoker = getObject(mixElementInvoker);
    var arrCheckbox = document.getElementsByName(strElementsName);
    for (var intCount = 0; intCount < arrCheckbox.length; ++intCount) {
        var elementCheckbox = arrCheckbox[intCount];
        if ((booNotUseDisabled === true) && (elementCheckbox.disabled))
            continue;
        elementCheckbox.checked = elementInvoker.checked;
        if (strFunctionExec != undefined)
            eval(replaceAll(strFunctionExec, 'this', "document.getElementById('" + elementCheckbox.id + "')"));
    }
    return true;
}

/**
 * Checa e descheca o elemento que invoca a acao de selecionar ou nao todos 
 * outros elementos de um determinado name
 *
 * @param MIX mixElementInvoker
 * @param STRING strElementsName
 * @param BOOLEAN booNotUseDisabled
 * @return BOOLEAN
 */
function checkUncheckInvoker(mixElementInvoker, strElementsName, booNotUseDisabled)
{
    if ((mixElementInvoker == undefined) || (strElementsName == undefined))
        return false;
    var elementInvoker = getObject(mixElementInvoker);
    var arrCheckbox = document.getElementsByName(strElementsName);
    var booChecked = true;
    for (var intCount = 0; intCount < arrCheckbox.length; ++intCount) {
        if ((booNotUseDisabled === true) && (arrCheckbox[intCount].disabled))
            continue;
        if (!arrCheckbox[intCount].checked) {
            booChecked = false;
            break;
        }
    }
    elementInvoker.checked = booChecked;
    return true;
}

/**
 * Cria um elemento em um repositorio
 *
 * @param MIX mixRepositoryElement
 * @param STRING strId
 * @param STRING strName
 * @param STRING strValue
 * @return OBJECT
 */
function createHiddenIntoRepository(mixRepositoryElement, strId, strName, strValue)
{
    if (mixRepositoryElement != undefined) {
        var repositoryElement = getObject(mixRepositoryElement);
        if (repositoryElement == undefined)
            return;
    }
    var inputHidden = document.createElement('INPUT');
    inputHidden.setAttribute('type', 'hidden');
    if (strId != undefined)
        inputHidden.id = strId;
    if (strName != undefined)
        inputHidden.name = strName;
    if (strValue != undefined)
        inputHidden.value = strValue;
    if (mixRepositoryElement != undefined)
        repositoryElement.appendChild(inputHidden);
    return inputHidden;
}

/**
 * Retorna um array com todos os valores do formulario
 * 
 * @param MIX mixForm
 * @return STRING
 */
function getValuesForm(mixForm)
{
    if (mixForm == undefined)
        return false;
    var form = getObject(mixForm);
    if (form == undefined)
        return false;
    var arrInput = form.getElementsByTagName('INPUT');
    var arrSelect = form.getElementsByTagName('SELECT');
    var arrTextarea = form.getElementsByTagName('TEXTAREA');
    var arrValuesForm = new Array();
    for (var intCount = 0; intCount < arrInput.length; ++intCount) {
        var input = arrInput[intCount];
        if ((input.getAttribute('name') == undefined) || (input.getAttribute('name') == null))
            continue;
        var booExec = ((input.type == 'checkbox') || (input.type == 'radio')) ? input.checked : true;
        if (booExec) {
            var strValue = input.value;
            var strName = input.getAttribute('name');
            if ((document.all) && (input.getAttribute('placeholder') == strValue))
                strValue = '';
            if (input.getAttribute('name') != '') {
                var intKey = arrValuesForm.length;
                arrValuesForm[intKey] = new Array();
                arrValuesForm[intKey][strName] = strValue;
            }
        }
    }
    for (intCount = 0; intCount < arrSelect.length; ++intCount) {
        var select = arrSelect[intCount];
        if ((select.getAttribute('name') == undefined) || (select.getAttribute('name') == null))
            continue;
        if ((isSelectMultiple(select)) && (select.getAttribute('name').indexOf(strGlobalSufixTransferNotSelectable) != -1))
            continue;
        var mixValue = captureValueFromElement(select);
        var strName = select.getAttribute('name');
        if (select.getAttribute('name') != '') {
            var intKey = arrValuesForm.length;
            arrValuesForm[intKey] = new Array();
            arrValuesForm[intKey][strName] = mixValue;
        }
    }
    for (intCount = 0; intCount < arrTextarea.length; ++intCount) {
        var textarea = arrTextarea[intCount];
        if ((textarea.getAttribute('name') == undefined) || (textarea.getAttribute('name') == null))
            continue;
        var strValue = textarea.value;
        var strName = textarea.getAttribute('name');
        if ((document.all) && (textarea.getAttribute('placeholder') == strValue))
            strValue = '';
        if (textarea.getAttribute('name') != '') {
            var intKey = arrValuesForm.length;
            arrValuesForm[intKey] = new Array();
            arrValuesForm[intKey][strName] = strValue;
        }
    }
    return arrValuesForm;
}

/**
 * Retorna a string referente a todos os parametros de um formulario + o atributo action
 * 
 * @param MIX mixForm
 * @param STRING strUrlBase
 * @return STRING
 */
function getUrlForm(mixForm, strUrlBase)
{
    var arrValuesForm = getValuesForm(mixForm);
    if (arrValuesForm == false)
        return false;
    var form = getObject(mixForm);
    if (strUrlBase == undefined)
        strUrlBase = form.getAttribute('action');
    var strUrl = strUrlBase;
    var strLastCharac = (strUrl != '') ? strUrl.substring((strUrl.length - 1)) : '';
    if ((strLastCharac != '?') && (strLastCharac != '&')) {
        var strSymbol = (strUrl.indexOf('?') == -1) ? '?' : '&';
        strUrl += strSymbol;
    }
    for (var intCount = 0; intCount < arrValuesForm.length; ++intCount) {
        for (var strName in arrValuesForm[intCount])
            strUrl += strName + '=' + arrValuesForm[intCount][strName] + '&';
    }
    return strUrl;
}

/**
 * "Submete" o formulario usando o method get com os nomes dos atributos em md5
 * e os valores em base64
 * 
 * @param MIX mixFormElement
 * @param STRING strUrlBase
 * @return BOOLEAN
 */
function submitGet(mixFormElement, strUrlBase)
{
    var mixUrl = getUrlForm(mixFormElement, strUrlBase);
    if (mixUrl === false)
        return mixUrl;
    window.location.href = mixUrl;
    return true;
}

/**
 * Captura os campos de um formulario
 *
 * @param MIX mixForm
 * @param BOOLEAN booShowHidden
 * @param BOOLEAN booShowDisabled
 * @return ARRAY
 */
function captureFieldsFromForm(mixForm, booShowHidden, booShowDisabled)
{
    if (mixForm == undefined)
        mixForm = 'frm';
    if (booShowHidden == undefined)
        booShowHidden = true;
    if (booShowDisabled == undefined)
        booShowDisabled = true;
    var form = getObject(mixForm);
    if (form == undefined)
        return false;
    var arrElementsInputForm = parseArray(form.getElementsByTagName('INPUT'));
    var arrElementsSelectForm = parseArray(form.getElementsByTagName('SELECT'));
    var arrElementsTextareaForm = parseArray(form.getElementsByTagName('TEXTAREA'));
    var arrElementsInputFormEdited = new Array();
    for (var intCount = 0; intCount < arrElementsInputForm.length; ++intCount) {
        var fieldInputForm = arrElementsInputForm[intCount];
        if ((fieldInputForm != undefined) && (isObject(fieldInputForm))) {
            if (booShowHidden)
                arrElementsInputFormEdited.push(fieldInputForm);
            else if (fieldInputForm.getAttribute('type') != 'hidden')
                arrElementsInputFormEdited.push(fieldInputForm);
        }
    }
    var arrElements = arrElementsInputFormEdited.concat(arrElementsSelectForm, arrElementsTextareaForm);
    var arrReturn = new Array();
    for (var intCount = 0; intCount < arrElements.length; ++intCount) {
        var fieldForm = arrElements[intCount];
        if ((fieldForm != undefined) && (isObject(fieldForm))) {
            if (booShowDisabled)
                arrReturn.push(fieldForm);
            else if (fieldForm.disabled == false)
                arrReturn.push(fieldForm);
        }
    }
    return arrReturn;
}

/**
 * Desabilita ou habilita todos os elementos nao ocultos de um formulario
 *
 * @param BOOLEAN booDisabled
 * @param MIX mixForm
 * @return BOOLEAN
 */
function disabledAllElementsFromForm(booDisabled, mixForm)
{
    if (booDisabled == undefined)
        booDisabled = true;
    var arrElements = captureFieldsFromForm(mixForm, false);
    for (var intCount = 0; intCount < arrElements.length; ++intCount) {
        if (arrElements[intCount] != undefined)
            arrElements[intCount].disabled = booDisabled;
    }
    return true;
}

/**
 * Limpa os campos de um formulario
 *
 * @param MIX mixForm
 * @param BOOLEAN booClearHidden
 * @param BOOLEAN booClearDisabled
 * @param ARRAY arrIdHiddenElementsRestrict
 * @param ARRAY arrIdDisabledElementsRestrict
 * @param STRING strFunctionExec
 * @return BOOLEAN
 */
function clearValuesFromFieldsForm(mixForm, booClearHidden, booClearDisabled, arrIdHiddenElementsRestrict, arrIdDisabledElementsRestrict, strFunctionExec)
{
    if (mixForm == undefined) {
        var arrForm = document.getElementsByTagName('FORM');
        if (arrForm.length == 0)
            return false;
        mixForm = arrForm[0];
    }
    if (booClearHidden == undefined)
        booClearHidden = false;
    if (booClearDisabled == undefined)
        booClearDisabled = false;
    var form = getObject(mixForm);
    if (form == undefined)
        return false;
    form.reset();
    var arrElements = captureFieldsFromForm(mixForm, booClearHidden, booClearDisabled);
    for (var intCount = 0; intCount < arrElements.length; ++intCount) {
        var element = arrElements[intCount];
        var strTagName = element.tagName + '';
        if (element.getAttribute) {
            if ((arrIdDisabledElementsRestrict != undefined) && (element.disabled == true) && (array_search(element.id, arrIdDisabledElementsRestrict) != -1))
                continue;
            switch (strTagName.toUpperCase()) {
                case 'SELECT':
                    {
                        if (element.options.length > 0)
                            element.options[0].selected = true;
                        break;
                    }
                case 'TEXTAREA':
                    {
                        element.value = '';
                        break;
                    }
                case 'INPUT':
                    {
                        switch (element.type.toUpperCase()) {
                            case 'RADIO':
                                {
                                    var arrRadio = document.getElementsByName(element.name);
                                    for (var intCount2 = 0; intCount2 < arrRadio.length; ++intCount2) {
                                        arrRadio[intCount2].checked = false;
                                        if ($('input[name="' + arrRadio[intCount2].name + '"]').parent().hasClass('active'))
                                            $('input[name="' + arrRadio[intCount2].name + '"]').parent().removeClass('active')
                                    }
                                    break;
                                }
                            case 'CHECKBOX':
                                {
                                    element.checked = false;
                                    break;
                                }
                            case 'HIDDEN':
                                {
                                    if (arrIdHiddenElementsRestrict != undefined) {
                                        if (array_search(element.id, arrIdHiddenElementsRestrict) == -1)
                                            element.value = "";
                                    } else
                                        element.value = "";
                                    break;
                                }
                            case 'FILE':
                                {
                                    if (document.all) {
                                        var strValueInputFile = element.value;
                                        element.outerHTML = replaceAll(element.outerHTML, strValueInputFile, '');
                                    } else
                                        element.value = '';
                                    var divInputFile = getObject('link_' + element.getAttribute('id'));
                                    if (divInputFile != undefined)
                                        divInputFile.innerHTML = '';
                                    break;
                                }
                            default:
                                {
                                    element.value = '';
                                    break;
                                }
                        }
                        break;
                    }
            }
        }
    }
    if (strFunctionExec != undefined)
        eval(strFunctionExec);
    return true;
}

/**
 * Captura o valor checado de um radio ou checkbox
 * 
 * @param STRING strNameRadioCheckbox
 * @return MIX
 */
function getValueFromRadioCheckbox(strNameRadioCheckbox)
{
    if (strNameRadioCheckbox == undefined)
        return false;
    var arrRadioCheckbox = document.getElementsByName(strNameRadioCheckbox);
    var arrValue = new Array();
    for (var intCount = 0; intCount < arrRadioCheckbox.length; ++intCount) {
        var radioCheckbox = arrRadioCheckbox[intCount];
        if (radioCheckbox.checked === true)
            arrValue[arrValue.length] = radioCheckbox.value;
    }
    var mixValueReturn = null;
    if (arrValue.length == 1)
        mixValueReturn = arrValue[0];
    else if (arrValue.length > 1)
        mixValueReturn = arrValue;
    return mixValueReturn;
}

/**
 * Seta o timeout para realizar a captura de um arquivo de um input file sem ter que submete-lo
 *
 * @param MIX mixInputFile
 * @return BOOLEAN
 */
function getFileFromInputFile(mixInputFile)
{
    if (mixInputFile == undefined)
        return false;
    var inputFile = getObject(mixInputFile);
    if ((inputFile == undefined) || (inputFile.value == ''))
        return false;
    setTimeout("getFileFromInputFileLink('" + inputFile.getAttribute("id") + "');", 500);
    return true;
}

/**
 * Cria um link para realizar a captura de um arquivo de um input file sem ter que submete-lo
 *
 * @param MIX mixInputFile
 * @return BOOLEAN
 */
function getFileFromInputFileLink(mixInputFile)
{
    if (mixInputFile == undefined)
        return false;
    var inputFile = getObject(mixInputFile);
    if ((inputFile == undefined) || (inputFile.value == ''))
        return false;
    var inputFileParent = inputFile.parentNode;
    var strInputFileId = inputFile.getAttribute('id');
    var strInputFileName = inputFile.getAttribute('name');
    var link = document.getElementById('link_' + strInputFileId);
    if (link != undefined)
        inputFileParent.removeChild(link);
    var link = document.createElement('DIV');
    var strInputValue = replaceAll(inputFile.value, '/', '\\');
    var arrInputValue = explode('\\', strInputValue);
    var strFileName = arrInputValue[(arrInputValue.length - 1)];
    link.innerHTML = '<u>' + strFileName + '</u>';
    link.style.cursor = 'pointer';
    link.setAttribute('id', 'link_' + strInputFileId);
    link.setAttribute('name', 'link_' + strInputFileName);
    link.setAttribute('title', 'Capturar arquivo: ' + inputFile.value);
    inputFileParent.appendChild(link);
    insertFunctionIntoEventElement(link, 'onclick', "alert('" + inputFile.getAttribute("id") + "');");
    return true;
}

/**
 * Seleciona ou desmarca todos os options do select
 *
 * @param MIX mixSelect
 * @param BOOLEAN booSelected
 * @return MIX
 */
function selectedAllOption(mixSelect, booSelected)
{
    var select = getObject(mixSelect);
    if (select == undefined)
        return false;
    if (booSelected == undefined)
        booSelected = true;
    var arrOption = select.getElementsByTagName('OPTION');
    for (var intCount = 0; intCount < arrOption.length; ++intCount) {
        var option = arrOption[intCount];
        option.selected = booSelected;
    }
    return arrOption;
}

/**
 * Transefere um option de um select para outro select
 *
 * @param MIX mixSelectNotSelectable
 * @param MIX mixSelectSelectable
 * @param STRING strSymbolDirection
 * @return BOOLEAN
 */
function transferOptions(mixSelectNotSelectable, mixSelectSelectable, strSymbolDirection, arrOptionValue)
{
    var selectNotSelectable = getObject(mixSelectNotSelectable);
    var selectSelectable = getObject(mixSelectSelectable);
    if ((selectNotSelectable == undefined) || (selectSelectable == undefined))
        return false;
    if (strSymbolDirection == undefined)
        strSymbolDirection = '>';
    var arrOptionNotSelectable = selectNotSelectable.getElementsByTagName('OPTION');
    var arrOptionSelectable = selectSelectable.getElementsByTagName('OPTION');
    if (strSymbolDirection.indexOf('<') != -1) {
        var arrOptionContainer = arrOptionSelectable;
        var selectDestination = selectNotSelectable;
    } else if (strSymbolDirection.indexOf('>') != -1) {
        var arrOptionContainer = arrOptionNotSelectable;
        var selectDestination = selectSelectable;
    } else
        return false;
    if ((strSymbolDirection.length == 1) && (arrOptionContainer.length == 0))
        return true;
    if (arrOptionValue != undefined) {
        if (!isArray(arrOptionValue)) {
            var arrOptionValueNew = new Array();
            arrOptionValueNew[arrOptionValueNew.length] = arrOptionValue;
            arrOptionValue = arrOptionValueNew;
        }
        for (var intCount = 0; intCount < arrOptionValue.length; ++intCount) {
            var mixOptionValue = arrOptionValue[intCount];
            for (var intCount2 = 0; intCount2 < arrOptionContainer.length; ++intCount2) {
                var option = arrOptionContainer[intCount2];
                var mixValue = captureValueFromElement(option);
                if (mixOptionValue == mixValue) {
                    selectDestination.appendChild(option);
                    option.selected = false;
                }
            }
        }
        return true;
    }
    var arrOption = new Array();
    for (var intCount = 0; intCount < arrOptionContainer.length; ++intCount) {
        var option = arrOptionContainer[intCount];
        if ((option.selected) || (strSymbolDirection.length > 1))
            arrOption[arrOption.length] = option;
    }
    for (var intCount = 0; intCount < arrOption.length; ++intCount) {
        var option = arrOption[intCount];
        selectDestination.appendChild(option);
        option.selected = false;
    }
    return true;
}

/**
 * Seleciona ou desmarca todos os options do select do transfer para uma submissao de formulario
 *
 * @param BOOLEAN booSelected
 * @return VOID
 */
function managerTransfer(booSelected)
{
    if (booSelected == undefined)
        booSelected = true;
    var arrSelect = document.getElementsByTagName('SELECT');
    for (var intCount = 0; intCount < arrSelect.length; ++intCount) {
        var select = arrSelect[intCount];
        if (document.all) {
            if ((select.getAttribute('multiple') === false) || (select.getAttribute('ondblclick') === false) || (select.getAttribute('ondblclick') == null) || (select.getAttribute('name') === false))
                continue;
        } else {
            if ((select.getAttribute('multiple') == null) || (select.getAttribute('ondblclick') == null) || (select.getAttribute('name') == null))
                continue;
        }
        if (select.getAttribute('ondblclick').toString().indexOf('transferOptions') != -1) {
            if (select.getAttribute('name').indexOf(strGlobalSufixTransferNotSelectable) == -1) {
                if (booSelected) {
                    var arrOption = selectedAllOption(select, booSelected);
                    if (arrOption.length == 0) {
                        select.disabled = booSelected;
                        createHiddenIntoRepository(getFormByElement(select), select.getAttribute('name') + '[Hidden]', replaceAll(select.getAttribute('name'), '[]', ''), null);
                    }
                } else
                    select.disabled = booSelected;
            } else
                select.disabled = booSelected;
        }
    }
    if (booSelected)
        setTimeout('managerTransfer(false);', 1000);
}

/**
 * Altera a mascara de um telefone a partir de um numero de DDD
 *
 * @param MIX mixDdd
 * @param MIX mixPhone
 * @return BOOLEAN
 */
function changeMaskPhoneFromDdd(mixDdd, mixPhone, strParamMask)
{
    var ddd = getObject(mixDdd);
    var phone = getObject(mixPhone);
    if ((ddd == undefined) || (phone == undefined))
        return false;
    var intDigit = 8;
    eval('var arrDdd9Digit = [11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 24, 27, 28];');
    for (var intCount = 0; intCount < arrDdd9Digit.length; ++intCount) {
        if (ddd.value != arrDdd9Digit[intCount])
            continue;
        intDigit = 9;
    }
    var strMask = '';
    for (var intCount = 0; intCount < intDigit; ++intCount) {
        if ((intDigit - intCount) == 4)
            strMask += '-';
        strMask += '9';
    }
    var strPhone = phone.value;
    if ((strPhone != '') && (intDigit == 9)) {
        var intMaxLength = (strPhone.indexOf('-') != -1) ? 10 : 9;
        while (strPhone.length < intMaxLength)
            strPhone = '0' + strPhone;
        phone.value = strPhone;
    }
    include_once('/CoreZend/library/Jquery-Validation/jquery-validation-1.13.1/jquery.validate.min.js');
    if (intDigit == 9) {
        if (strParamMask.indexOf(strMask) == -1)
            strParamMask = replaceAll(strParamMask, '9999-9999', strMask);
    } else {
        if (strParamMask.indexOf('9' + strMask) != -1)
            strParamMask = replaceAll(strParamMask, '9' + strMask, strMask);
    }
    
    eval('$(phone).mask("' + strMask + '"' + strParamMask + ');');
    return true;
}