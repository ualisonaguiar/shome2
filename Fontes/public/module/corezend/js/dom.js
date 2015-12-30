/**
 * Retorna um objeto pelo ID
 *
 * @param MIX mixElement
 * @return OBJECT
 */
function getObject(mixElement)
{
    var element = undefined;
    if (isObject(mixElement))
        element = mixElement;
    else {
        element = document.getElementById(mixElement);
        if ((document.all) && (element != undefined) && (element.getAttribute('id') != mixElement)) {
            var elementIntern = undefined;
            var arrElement = document.getElementsByName(mixElement);
            for (var intCount = 0; intCount < arrElement.length; ++intCount) {
                if (arrElement[intCount].getAttribute('id') == mixElement) {
                    elementIntern = arrElement[intCount];
                    break;
                }
            }
            if (elementIntern != undefined)
                element = elementIntern;
        }
    }
    return element;
}

/**
 * Verifica se determinado atributo do objeto eh vazio ou nao existe
 * 
 * @param MIX mixElement
 * @param STRING strAttributeName
 * @return ARRAY
 */
function isEmptyAttribute(mixElement, strAttributeName)
{
    if ((mixElement == undefined) || (strAttributeName == undefined))
        return false;
    var element = getObject(mixElement);
    if (element == undefined)
        return false;
    return ((element.getAttribute(strAttributeName) == undefined) || (element.getAttribute(strAttributeName) === false) || (element.getAttribute(strAttributeName) == ''));
}

/**
 * Retorna elementos de um repositorio que possuem determinados atributos e valores (via regex)
 * 
 * @param OBJECT element
 * @param MIX mixTagName
 * @param STRING strAttributeName
 * @param STRING strAttributeValue
 * @return ARRAY
 */
function getElementsByAttribute(element, mixTagName, strAttributeName, strAttributeValue)
{
    if (typeof(mixTagName) == 'string')
        var arrElement = ((mixTagName == '*') && (element.all)) ? element.all : element.getElementsByTagName(mixTagName);
    else if (typeof(mixTagName) == 'object') {
        var arrElement = new Array();
        var arrOneOfElement = undefined;
        for (var intCount = 0; intCount < mixTagName.length; ++intCount) {
            arrOneOfElement = element.getElementsByTagName(mixTagName[intCount]);
            arrElement.concat(arrOneOfElement);
        }
    } else
        var arrElement = element.all;
    var arrReturnElement = new Array();
    var mixAttributeValue = (typeof strAttributeValue != 'undefined') ? new RegExp('(^|\\s)' + strAttributeValue + '(\\s|$)') : null;
    var current = undefined;
    var attribute = undefined;
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        current = arrElement[intCount];
        attribute = current.getAttribute && current.getAttribute(strAttributeName);
        if (attribute != undefined) {
            if (document.all)
                attribute = attribute.toString();
            if ((typeof attribute == 'string') && (attribute.length > 0)) {
                if (typeof strAttributeValue == 'undefined' || (mixAttributeValue && mixAttributeValue.test(attribute)))
                    arrReturnElement.push(current);
            }
        }
    }
    return arrReturnElement;
}

/**
 * Retorna elementos de um repositorio que possuem determinados atributos e valores (via DOM)
 * 
 * @param MIX mixRepository
 * @param STRING strTagName
 * @param STRING strAttributeName
 * @param STRING strAttributeValue
 * @param BOOLEAN booPartValue
 * @return ARRAY
 */
function getElementsFromAttribute(mixRepository, strTagName, strAttributeName, strAttributeValue, booPartValue)
{
    if ((strTagName == undefined) || (strAttributeName == undefined) || (strAttributeValue == undefined))
        return new Array();
    if (booPartValue)
        booPartValue = false;
    if (mixRepository == undefined)
        mixRepository = document.body;
    var repository = getObject(mixRepository);
    if (repository == undefined)
        return new Array();
    var arrElement = repository.getElementsByTagName(strTagName);
    var arrReturn = new Array();
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        var strAttributeValueElement = (strAttributeName == 'class') ? arrElement[intCount].className : arrElement[intCount].getAttribute(strAttributeName);
        if (booPartValue) {
            if (strAttributeValueElement.indexOf(strAttributeValue) != -1)
                arrReturn.push(arrElement[intCount]);
        } else if (strAttributeValueElement == strAttributeValue)
            arrReturn.push(arrElement[intCount]);
    }
    return arrReturn;
}

/**
 * Remove os objetos filhos (ou determinado objeto filho) de um objeto parametrizado
 *
 * @param MIX mixElement
 * @param STRING strIdChild
 * @return BOOLEAN
 */
function removeChildNodes(mixElement, strIdChild)
{
    if (mixElement == undefined)
        return false;
    var element = getObject(mixElement);
    while (element.childNodes.length > 0) {
        if ((strIdChild == undefined) || (strIdChild == element.id))
            element.removeChild(element.childNodes[0], true);
    }
    if ((document.all) && (element.tagName.toLowerCase() == 'div'))
        element.outerHTML = element.outerHTML;
    return true;
}

/**
 * Retorna o value do elemento
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function captureValueFromElement(mixElement)
{
    if (mixElement == undefined)
        return false;
    var element = getObject(mixElement);
    if (element == undefined)
        return false;
    if (isSelectMultiple(element)) {
        var arrValue = new Array();
        var arrOption = element.getElementsByTagName('OPTION');
        for (var intCount = 0; intCount < arrOption.length; ++intCount) {
            var option = arrOption[intCount];
            if (option.selected)
                arrValue[arrValue.length] = option.value;
        }
        return arrValue;
    }
    if (element.value != undefined)
        return element.value;
    if (element.innerHTML != undefined)
        return element.innerHTML;
    if (element.textContent != undefined)
        return element.textContent;
    if (element.text != undefined)
        return element.text;
}

/**
 * Caso o objeto esteja oculta, visualiza-o e vice-versa
 *
 * @param MIX mixElement
 * @return BOOL
 */
function showHide(mixElement)
{
    if (mixElement == undefined)
        return false;
    var element = getObject(mixElement);
    if (element.style.display == 'none') {
        element.style.display = '';
        return true;
    } else {
        element.style.display = 'none';
        return false;
    }
}

/**
 * Oculta o objeto
 *
 * @param MIX mixElement
 * @return VOID
 */
function hideObject(mixElement)
{
    if (mixElement == undefined)
        return false;
    var element = getObject(mixElement);
    if (isObject(element))
        element.style.display = 'none';
}

/**
 * Visualiza o objeto
 *
 * @param MIX mixElement
 * @return VOID
 */
function showObject(mixElement)
{
    if (mixElement == undefined)
        return false;
    var element = getObject(mixElement);
    if (isObject(element))
        element.style.display = '';
}

/**
 * Aplica o display a um array de elementos
 *
 * @param ARRAY arrElement
 * @param STRING strDisplay
 * @return BOOLEAN
 */
function showHideObjects(arrElement, strDisplay)
{
    if (arrElement == undefined)
        return false;
    if (!isArray(arrElement))
        arrElement = new Array(arrElement);
    if (strDisplay == undefined)
        strDisplay = '';
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        var mixElement = arrElement[intCount];
        var element = getObject(mixElement);
        if (element != undefined)
            element.style.display = strDisplay;
    }
    return true;
}

/**
 * Cria um elemento em um repositorio
 *
 * @param STRING strElementTag
 * @param MIX mixRepositoryElement
 * @param STRING strId
 * @param STRING strName
 * @param STRING strClass
 * @param STRING strStyle
 * @param BOOLEAN booStart
 * @param OBJECT element
 * @return OBJECT
 */
function createElementIntoRepository(strElementTag, mixRepositoryElement, strId, strName, strClass, strStyle, booStart, element)
{
    if (strElementTag == undefined)
        strElementTag = 'DIV';
    if (mixRepositoryElement == undefined)
        mixRepositoryElement = document.body;
    if (booStart == undefined)
        booStart = false;
    var repositoryElement = getObject(mixRepositoryElement);
    if (repositoryElement == undefined)
        return;
    if (element == undefined)
        element = document.createElement(strElementTag.toUpperCase());
    if (strId != undefined)
        element.setAttribute('id', strId);
    if (strName != undefined)
        element.setAttribute('name', strName);
    if (strClass != undefined)
        element.className = strClass;
    if (strStyle != undefined)
        element.style.cssText = strStyle;
    if (booStart) {
        if (checkIfExistsElementIntoRepositoy(element, repositoryElement) == false) {
            var strOldValues = repositoryElement.innerHTML;
            repositoryElement.innerHTML = "";
            repositoryElement.appendChild(element);
            repositoryElement.innerHTML += strOldValues;
        }
    } else
        repositoryElement.appendChild(element);
    return element;
}

/**
 * Verifica se o elemento existe dentro de um repositorio
 *
 * @param OBJECT element
 * @param OBJECT repositoryElement
 * @return BOOLEAN
 */
function checkIfExistsElementIntoRepositoy(element, repositoryElement)
{
    var arrChildElementFromRepositoy = repositoryElement.childNodes;
    for (var intCount = 0; intCount < arrChildElementFromRepositoy.length; ++intCount) {
        if ((arrChildElementFromRepositoy[intCount]) && (arrChildElementFromRepositoy[intCount] == element))
            return true;
    }
    return false;
}

/**
 * Remove um elemento dentro de um repositorio
 *
 * @param OBJECT repositoryElement
 * @param STRING strId
 * @return BOOLEAN
 */
function removeElementFromRepository(repositoryElement, strId)
{
    if (strId == undefined)
        return false;
    if (repositoryElement == undefined)
        repositoryElement = document.body;
    var arrElement = repositoryElement.childNodes;
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        if ((arrElement[intCount]) && (arrElement[intCount].id == strId)) {
            repositoryElement.removeChild(document.getElementById(strId));
            break;
        }
    }
    return true;
}

/**
 * Insere valor para um elemento existente na janela pai (opener)
 * 
 * @param STRING strValue
 * @param MIX mixOpenerElement
 * @param STRING strSeparator
 * @return MIX
 */
function insertValueToOpenerElement(strValue, mixOpenerElement, strSeparator)
{
    if ((strValue == undefined) || (mixOpenerElement == undefined))
        return false;
    if (isObject(mixOpenerElement))
        var openerElement = mixOpenerElement;
    else {
        if (opener == undefined) {
            alert('A janela-pai n&atilde;o foi encontrada e n&atilde;o &eacute; poss&iacute;vel realizar a opera&ccedil;&atilde;o!');
            return false;
        }
        try {
            var openerElement = opener.document;
        }
        catch (exception) {
            alert('A janela-pai n&atilde;o foi encontrada e n&atilde;o &eacute; poss&iacute;vel realizar a opera&ccedil;&atilde;o!');
            return false;
        }
        var openerElement = opener.document.getElementById(mixOpenerElement);
    }
    if (openerElement == undefined)
        return false;
    var strTagName = openerElement.tagName + '';
    strTagName = strTagName.toUpperCase();
    if ((strTagName != 'INPUT') && (strTagName != 'SELECT') && (strTagName != 'BUTTON'))
        openerElement.innerHTML = ((strSeparator == undefined) || (openerElement.innerHTML == '')) ? strValue : openerElement.innerHTML + strSeparator + strValue;
    else
        openerElement.value = ((strSeparator == undefined) || (openerElement.value == '')) ? strValue : openerElement.value + strSeparator + strValue;
    return true;
}

/**
 * Aplica o disabled a um array de elementos
 *
 * @param ARRAY arrElement
 * @param STRING strDisplay
 * @param BOOLEAN booClearDisable
 * @return BOOLEAN
 */
function disableObjects(arrElement, booDisable, booClearDisable)
{
    if (arrElement == undefined)
        return false;
    if (!isArray(arrElement))
        arrElement = new Array(arrElement);
    if (booDisable == undefined)
        booDisable = false;
    if (booClearDisable == undefined)
        booClearDisable = false;
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        var mixElement = arrElement[intCount];
        var element = getObject(mixElement);
        if (element != undefined)
            element.disabled = booDisable;
        if ((booClearDisable) && (booDisable))
            element.value = '';
    }
    return true;
}

/**
 * Retorno o objeto Document de um determinado IFRAME
 *
 * @param STRING strIdIframe
 * @return OBJECT
 */
function getDocumentFromIframe(strIdIframe)
{
    var documentElement = undefined;
    try {
        if (document.all)
            eval('documentElement = document.frames[\'' + strIdIframe + '\'].document;');
        if (documentElement == undefined)
            eval('documentElement = parent.document.getElementById("' + strIdIframe + '").contentDocument;');
    }
    catch (exception) {
        return;
    }
    return documentElement;
}

/**
 * Clona um elemento ou nodo
 *
 * @param MIX mixNode
 * @return MIX
 */
function cloneNode(mixNode)
{
    if (mixNode == undefined)
        return false;
    var node = getObject(mixNode);
    if (node == undefined)
        return false;
    var nodeClone = node.cloneNode(true);
    var arrTextarea = node.getElementsByTagName('TEXTAREA');
    var arrTextareaClone = nodeClone.getElementsByTagName('TEXTAREA');
    var arrInput = node.getElementsByTagName('INPUT');
    var arrInputClone = nodeClone.getElementsByTagName('INPUT');
    var arrSelect = node.getElementsByTagName('SELECT');
    var arrSelectClone = nodeClone.getElementsByTagName('SELECT');
    for (var intCount = 0; intCount < arrTextarea.length; ++intCount)
        arrTextareaClone[intCount].value = arrTextarea[intCount].value;
    for (var intCount = 0; intCount < arrInput.length; ++intCount) {
        if (arrInput[intCount].type == 'text')
            continue;
        if ((arrInput[intCount].type == 'radio') || (arrInput[intCount].type == 'checkbox'))
            arrInputClone[intCount].checked = arrInput[intCount].checked;
        else {
            try {
                arrInputClone[intCount].value = arrInput[intCount].value;
            } catch (exception) {

            }
        }
    }
    for (var intCount = 0; intCount < arrSelect.length; ++intCount)
        arrSelectClone[intCount].value = arrSelect[intCount].value;
    return nodeClone;
}

/**
 * Cria recursivamente um objeto atraves de uma string com objetos e arrays
 *
 * @param STRING strAttributeHierarchy
 * @param MIX mixAttributeValue
 * @param OBJECT container
 * @param MIX mixPartHierarchy
 * @return MIX
 */
function createAttributeHierarchyIntoObject(strAttributeHierarchy, mixAttributeValue, container, mixPartHierarchy)
{
    if (strAttributeHierarchy == undefined)
        return false;
    if (container == undefined)
        container = new Object();
    var intPosOpenArray = strrpos(strAttributeHierarchy, '[');
    var intPosOpenObject = strrpos(strAttributeHierarchy, '.');
    if ((intPosOpenArray === false) && (intPosOpenObject === false)) {
        var mixValue = (mixPartHierarchy == undefined) ? mixAttributeValue : mixPartHierarchy;
        eval('container.' + replaceAll(strAttributeHierarchy, ']', '') + ' = mixValue;');
        return container;
    } else if (((intPosOpenArray !== false) && (intPosOpenObject === false)) || (intPosOpenArray > intPosOpenObject)) {
        var strKey = strAttributeHierarchy.substr(intPosOpenArray + 1);
        var intPosClose = strKey.indexOf(']');
        if (intPosClose == 0)
            strKey = 0;
        else if (intPosClose > 0)
            var strKey = strKey.substr(0, intPosClose);
        var mixValue = new Array();
        mixValue[strKey] = (mixPartHierarchy == undefined) ? mixAttributeValue : mixPartHierarchy;
        return createAttributeHierarchyIntoObject(strAttributeHierarchy.substr(0, intPosOpenArray), mixAttributeValue, container, mixValue);
    } else if (((intPosOpenArray === false) && (intPosOpenObject !== false)) || (intPosOpenArray < intPosOpenObject)) {
        var strKey = strAttributeHierarchy.substr(intPosOpenObject + 1);
        if (isNumeric(strKey))
            strKey = '_' + strKey;
        var mixValue = new Object();
        eval('mixValue.' + strKey + ' = (mixPartHierarchy == undefined) ? mixAttributeValue : mixPartHierarchy;');
        return createAttributeHierarchyIntoObject(strAttributeHierarchy.substr(0, intPosOpenObject), mixAttributeValue, container, mixValue);
    }
}

/**
 * Controla o tamanho das fontes
 *
 * @param STRING strSymbol // Simbolo que controla a operacao, ou seja, + para aumentar, - para diminuir a fonte e 0 para retornar o tamanho original
 * @param INTEGER intPercentMax	// Percentual maximo que se queira aumentar uma fonte (lembrando que a fonte inicial possui percentual de 100) - parametro opcional
 * @param INTEGER intPercentMin	// Percentual minimo que se queira diminuir uma fonte (lembrando que a fonte inicial possui percentual de 100) - parametro opcional
 * @param INTEGER intPercentOperation // Percentual que eh trabalhado em cada operacao - parametro opcional (default = 5)
 * @return BOOLEAN
 */
var intPercentFontSizeGlobal = 100;
function controlFontSize(strSymbol, intPercentMax, intPercentMin, intPercentOperation, strClassFontSize, arrTagFontSize)
{
    if ((strSymbol == undefined) || ((strSymbol != '+') && (strSymbol != '-')))
        strSymbol = '0';
    if (intPercentOperation == undefined)
        intPercentOperation = 5;
    if (strSymbol == '0')
        var intPercentFontSize = 100;
    else
        eval('var intPercentFontSize = intPercentFontSizeGlobal ' + strSymbol + ' ' + intPercentOperation + ';');
    if ((intPercentMax != undefined) && (intPercentFontSize > intPercentMax))
        return false;
    if ((intPercentMin != undefined) && (intPercentFontSize < intPercentMin))
        return false;
    setTimeout('openWaitDialog();', 100);
    if (strClassFontSize == undefined)
        strClassFontSize = 'controlFontSize';
    intPercentFontSizeGlobal = intPercentFontSize;
    if (arrTagFontSize == undefined)
        arrTagFontSize = new Array('BODY', 'FORM', 'DIV', 'LABEL', 'SPAN', 'FONT', 'INPUT', 'TEXTAREA', 'SELECT', 'TABLE', 'TBODY', 'THEAD', 'TR', 'TH', 'TD', 'P', 'A', 'STRONG', 'B', 'LI', /*'H1', 'H2', 'H3', 'H4', */'H5', 'H6');
    var arrElement = new Array();
    for (var intCount = 0; intCount < arrTagFontSize.length; ++intCount) {
        var arrTag = getElementsFromAttribute(document, arrTagFontSize[intCount], 'class', strClassFontSize, true);
        if (arrTag.length != 0)
            arrElement = arrElement.concat(arrTag);
    }
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        var arrChild = getChildNodesRecursive(arrElement[intCount], arrTagFontSize);
        arrElement = arrElement.concat(arrChild);
    }
    for (var intCount = 0; intCount < arrElement.length; ++intCount) {
        var tag = arrElement[intCount];
        if (tag.style.fontSize != undefined)
            tag.style.fontSize = intPercentFontSizeGlobal + '%';
    }
    setTimeout('closeWaitDialog();', 110);
    return true;
}

/**
 * Captura recursivamente todos os elementos filhos (com possibilidade de restricao de determinadas tags)
 *
 * @param MIX mixElement
 * @param ARRAY arrTag
 * @return BOOLEAN
 */
function getChildNodesRecursive(mixElement, arrTag)
{
    var element = getObject(mixElement);
    if (!isObject(element))
        return;
    var arrElement = new Array();
    try {
        if (element.hasChildNodes()) {
            var arrChild = element.childNodes;
            for (var intCount = 0; intCount < arrChild.length; ++intCount) {
                var child = arrChild[intCount];
                if (child.nodeType === 1) {
                    if (isArray(arrTag)) {
                        var booContinue = true;
                        for (var intCount2 = 0; intCount2 < arrTag.length; ++intCount2) {
                            if (arrTag[intCount2].toLowerCase() == child.tagName.toLowerCase()) {
                                booContinue = false;
                                break;
                            }
                        }
                        if (booContinue)
                            continue;
                    }
                    arrElement[arrElement.length] = child;
                    var arrElementRecursive = getChildNodesRecursive(child, arrTag);
                    arrElement = arrElement.concat(arrElementRecursive);
                }
            }
        }
    }
    catch (exception) {

    }
    return arrElement;
}

/**
 * Verifica se o elemento eh um select multiple
 *
 * @param MIX mixSelect
 * @return MIX
 */
function isSelectMultiple(mixSelect)
{
    if (mixSelect == undefined)
        return false;
    var select = getObject(mixSelect);
    if (select == undefined)
        return false;
    if (select.tagName.toLowerCase() != 'select')
        return false;
    var booMultiple = true;
    if (document.all)
        booMultiple = (select.getAttribute('multiple') === false) ? false : true;
    else
        booMultiple = (select.getAttribute('multiple') == null) ? false : true;
    return booMultiple;
}

/**
 * Define o valor do atributo HTML autocomplete
 *
 * @param MIX mixElement
 * @param STRING strValue
 * @return MIX
 */
function setAutocomplete(mixElement, strValue)
{
    if (mixElement == undefined)
        return false;
    var element = getObject(mixElement);
    if (element == undefined)
        return false;
    if (strValue == undefined)
        strValue = '';
    strValue = strValue.toLowerCase();
    if ((strValue != 'on') && (strValue != 'off'))
        strValue = 'on';
    return element.setAttribute('autocomplete', strValue);
}

function setJsonParamIntoInputHidden(arrParam, strInputHiddenParam)
{
    if (isArray(arrParam)) {
        if (strInputHiddenParam == undefined)
            strInputHiddenParam = 'filter_criteria';
        var inputHiddenParam = getObject(strInputHiddenParam);
        if (inputHiddenParam == undefined) {
            createElementIntoRepository('INPUT', document.body, strInputHiddenParam);
            inputHiddenParam = getObject(strInputHiddenParam);
            inputHiddenParam.setAttribute('type', 'hidden');
        }
        var arrParamJson = new Array();
        for (var mixKey in arrParam) {
            if (arrParam[mixKey] == undefined)
                continue;
            arrParamJson[arrParamJson.length] = JSON.stringify(new Array(mixKey, arrParam[mixKey]));
        }
        inputHiddenParam.value = JSON.stringify(arrParamJson);
        return true;
    }
    return false;
}