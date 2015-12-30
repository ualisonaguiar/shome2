function setEvent(mixElement, strEvent, mixFunction)
{
    if ((mixElement == undefined) || (strEvent == undefined) || (mixFunction == undefined))
        return false;
    var element = getObject(mixElement);
    if (element == undefined)
        return false;
    var strBindEvent = replaceAll(strEvent, 'pre-', '');
    if (isFunction(mixFunction))
        $(element).bind(strBindEvent, mixFunction);
    else {
        $(element).bind(strBindEvent, function() {
            if (mixFunction.indexOf('return false') === 0)
                return false;
            if ((strEvent == 'paste') || (strEvent == 'drop'))
                setTimeout("eval(\"" + mixFunction + "\");", 50);
            else
                eval(mixFunction);
            return true;
        });
    }
    return true;
}

function clearEvent(strEvent)
{
    return setEvent(window, strEvent, function() {
        return void(0);
    });
}

function setOnBeforeUnload(mixElement, mixFunction)
{
    return setEvent(mixElement, 'beforeunload', mixFunction);
}

function setOnBlur(mixElement, mixFunction)
{
    return setEvent(mixElement, 'blur', mixFunction);
}

function setOnChange(mixElement, mixFunction)
{
    return setEvent(mixElement, 'change', mixFunction);
}

function setOnClick(mixElement, mixFunction)
{
    return setEvent(mixElement, 'click', mixFunction);
}

function setOnContextMenu(mixElement, mixFunction)
{
    return setEvent(mixElement, 'contextmenu', mixFunction);
}

function setOnCopy(mixElement, mixFunction)
{
    return setEvent(mixElement, 'copy', mixFunction);
}

function setOnCut(mixElement, mixFunction)
{
    return setEvent(mixElement, 'cut', mixFunction);
}

function setOnDblClick(mixElement, mixFunction)
{
    return setEvent(mixElement, 'dblclick', mixFunction);
}

function setOnDrag(mixElement, mixFunction)
{
    return setEvent(mixElement, 'drag', mixFunction);
}

function setOnDragEnd(mixElement, mixFunction)
{
    return setEvent(mixElement, 'dragend', mixFunction);
}

function setOnDragEnter(mixElement, mixFunction)
{
    return setEvent(mixElement, 'dragenter', mixFunction);
}

function setOnDragLeave(mixElement, mixFunction)
{
    return setEvent(mixElement, 'dragleave', mixFunction);
}

function setOnDragOver(mixElement, mixFunction)
{
    return setEvent(mixElement, 'dragover', mixFunction);
}

function setOnDragStart(mixElement, mixFunction)
{
    return setEvent(mixElement, 'dragstart', mixFunction);
}

function setOnDrop(mixElement, mixFunction)
{
    return setEvent(mixElement, 'drop', mixFunction);
}

function setOnError(mixElement, mixFunction)
{
    return setEvent(mixElement, 'error', mixFunction);
}

function setOnFocus(mixElement, mixFunction)
{
    return setEvent(mixElement, 'focus', mixFunction);
}

function setOnHashChange(mixElement, mixFunction)
{
    return setEvent(mixElement, 'hashchange', mixFunction);
}

function setOnInput(mixElement, mixFunction)
{
    return setEvent(mixElement, 'input', mixFunction);
}

function setOnKeyDown(mixElement, mixFunction)
{
    return setEvent(mixElement, 'keydown', mixFunction);
}

function setOnKeyPress(mixElement, mixFunction)
{
    return setEvent(mixElement, 'keypress', mixFunction);
}

function setOnKeyUp(mixElement, mixFunction)
{
    return setEvent(mixElement, 'keyup', mixFunction);
}

function setOnLoad(mixElement, mixFunction)
{
    return setEvent(mixElement, 'load', mixFunction);
}

function setOnMessage(mixElement, mixFunction)
{
    return setEvent(mixElement, 'message', mixFunction);
}

function setOnMouseDown(mixElement, mixFunction)
{
    return setEvent(mixElement, 'mousedown', mixFunction);
}

function setOnMouseMove(mixElement, mixFunction)
{
    return setEvent(mixElement, 'mousemove', mixFunction);
}

function setOnMouseOut(mixElement, mixFunction)
{
    return setEvent(mixElement, 'mouseout', mixFunction);
}

function setOnMouseOver(mixElement, mixFunction)
{
    return setEvent(mixElement, 'mouseover', mixFunction);
}

function setOnMouseUp(mixElement, mixFunction)
{
    return setEvent(mixElement, 'mouseup', mixFunction);
}

function setOnMouseWheel(mixElement, mixFunction)
{
    return setEvent(mixElement, 'mousewheel', mixFunction);
}

function setOnPaste(mixElement, mixFunction)
{
    return setEvent(mixElement, 'paste', mixFunction);
}

function setOnPrePaste(mixElement, mixFunction)
{
    return setEvent(mixElement, 'pre-paste', mixFunction);
}

function setOnPasteDrop(mixElement, mixFunction)
{
    var booReturn = setOnPaste(mixElement, mixFunction);
    if (booReturn)
        booReturn = setOnDrop(mixElement, mixFunction);
    return booReturn;
}

function setNotPaste(mixNotPaste)
{
    if (mixNotPaste == undefined)
        return false;
    var arrNotPaste = (isArray(mixNotPaste)) ? mixNotPaste : new Array(mixNotPaste);
    for (var intCount = 0; intCount < arrNotPaste.length; ++intCount) {
        var notPaste = getObject(arrNotPaste[intCount]);
        if (notPaste != undefined)
            setOnPrePaste(notPaste, 'return false;');
    }
    return true;
}

function setOnReset(mixElement, mixFunction)
{
    return setEvent(mixElement, 'reset', mixFunction);
}

function setOnResize(mixElement, mixFunction)
{
    return setEvent(mixElement, 'resize', mixFunction);
}

function setOnScroll(mixElement, mixFunction)
{
    return setEvent(mixElement, 'scroll', mixFunction);
}

function setOnSelect(mixElement, mixFunction)
{
    return setEvent(mixElement, 'select', mixFunction);
}

function setOnSubmit(mixElement, mixFunction)
{
    return setEvent(mixElement, 'submit', mixFunction);
}

function setOnUnload(mixElement, mixFunction)
{
    return setEvent(mixElement, 'unload', mixFunction);
}

function clearBeforeUnload()
{
    return clearEvent('beforeunload');
}

/**
 * Funcao que atualiza a tela window
 *
 * @param ARRAY arrParamNotUse
 * @param STRING strParamComplement
 * @param BOOLEAN booNotUseAllParam
 * @return BOOLEAN
 */
function refreshWindow(arrParamNotUse, strParamComplement, booNotUseAllParam)
{
    if (arrParamNotUse == undefined)
        arrParamNotUse = new Array();
    if (!isArray(arrParamNotUse))
        arrParamNotUse = new Array(arrParamNotUse);
    var arrUrl = explode('#', window.location.href);
    var strUrl = arrUrl[0];
    if (strUrl.indexOf('?') != -1) {
        if (booNotUseAllParam === true)
            strUrl = strUrl.substring(0, strUrl.indexOf('?'));
        else {
            var arrUrlParam = explode('?', strUrl);
            arrUrlParam = explode('&', arrUrlParam[1]);
            for (var intCount = 0; intCount < arrParamNotUse.length; ++intCount) {
                var strParamNotUse = arrParamNotUse[intCount];
                for (var intCount2 = 0; intCount2 < arrUrlParam.length; ++intCount2) {
                    var strUrlParam = arrUrlParam[intCount2];
                    if (strUrlParam.indexOf(strParamNotUse) != -1) {
                        strUrl = replaceAll(strUrl, strUrlParam, '');
                        break;
                    }
                }
            }
            strUrl = replaceAll(strUrl, '?&', '?');
            strUrl = replaceAll(strUrl, '&&', '&');
        }
    }
    if (strUrl.substring((strUrl.length - 1)) == '?')
        strUrl = replaceAll(strUrl, '?', '');
    if (strUrl.substring((strUrl.length - 1)) == '&')
        strUrl = replaceAll(strUrl, '&', '');
    var strSymbol = (strUrl.indexOf('?') == -1) ? '?' : '&';
    if (strParamComplement != undefined)
        strUrl += strSymbol + strParamComplement;
    window.location.href = strUrl;
    return true;
}

/**
 * Funcao que atualiza a tela parent (pai da tela de popup)
 *
 * @return BOOLEAN
 */
function refreshParent()
{
    window.opener.location.href = window.opener.location.href;
    window.close();
    return true;
}

/**
 * Atualiza a janela pai com a URL da janela filho
 * 
 * @return VOID
 */
function refreshParentWithCurrentUrl()
{
    var booExecute = false;
    try {
        if ((parent != undefined) && (parent.window != undefined) && (parent.window.location.href != window.location.href))
            booExecute = true;
    }
    catch (exception) {
        if ((exception + ''.toLowerCase().indexOf('location.href') != -1) && (exception + "".toLowerCase().indexOf('https://') != -1))
            booExecute = true;
    }
    if (booExecute == true)
        parent.window.location.href = replaceAll(window.location.href, 'https://', 'http://');
    return;
}

/**
 * Executa uma funcao aplicada ao evento onload do objeto window
 *
 * @param STRING strFunction
 * @return VOID
 */
function execFunctionOnLoadEvent(strFunction)
{
    if (strFunction == undefined)
        return;
    var mixWindowLoad = window.onload;
    window.onload = function() {
        if (mixWindowLoad)
            mixWindowLoad();
        eval(strFunction);
    };
    return;
}

/**
 * Insere uma funcao a um evento aplicado a um determinado elemento
 *
 * @param MIX mixElement
 * @param STRING strEvent
 * @param STRING strEventFunction
 * @param BOOLEAN booClear
 * @return BOOL
 */
function insertFunctionIntoEventElement(mixElement, strEvent, strEventFunction, booClear)
{
    if ((mixElement == undefined) || (strEvent == undefined))
        return false;
    if (booClear == undefined)
        booClear = false;
    var element = getObject(mixElement);
    var strEventFunctionIntern = element.getAttribute(strEvent);
    if (strEventFunctionIntern == undefined)
        strEventFunctionIntern = '';
    else if (document.all) {
        strEventFunctionIntern = replaceAll(strEventFunctionIntern, 'function anonymous() {', '');
        strEventFunctionIntern = strEventFunctionIntern.substring(0, (strEventFunctionIntern.length - 2));
        strEventFunctionIntern = replaceAll(strEventFunctionIntern, '\n', '');
    }
    strEventFunctionIntern = (booClear === false) ? strEventFunction + strEventFunctionIntern : strEventFunction;
    if (document.all)
        eval('element.' + strEvent + ' = new Function("' + strEventFunctionIntern + '");');
    else
        element.setAttribute(strEvent, strEventFunctionIntern);
    return true;
}

/**
 * Funcao que aciona a contagem regressiva de uma data futura ate a data atual e 
 * executa uma funcao quando a contagem nao zerar e/ou quando zerar
 *
 * @param INTEGER intTimestamp
 * @param STRING strFunctionExecNoZero
 * @param STRING strFunctionExecZero
 * @return MIX
 */
var intGlobalIntervalRegressiveCount;
function regressiveCount(intTimestamp, strFunctionExecNoZero, strFunctionExecZero)
{
    if (intTimestamp == undefined)
        return false;
    intGlobalIntervalRegressiveCount = setInterval('regressiveCountInternval("' + intTimestamp + '", "' + strFunctionExecNoZero + '", "' + strFunctionExecZero + '");', 1000);
    return intGlobalIntervalRegressiveCount;
}

/**
 * Funcao que aciona a contagem regressiva de uma data futura ate a data atual apos a
 * aplicacao do intervalo
 *
 * @param INTEGER intTimestamp
 * @param STRING strFunctionExecNoZero
 * @param STRING strFunctionExecZero
 * @return BOOLEAN
 */
var intGlobalHoursRegressiveCount;
var intGlobalMinutesRegressiveCount;
var intGlobalSecondsRegressiveCount;
function regressiveCountInternval(intTimestamp, strFunctionExecNoZero, strFunctionExecZero)
{
    var date = new Date();
    var intTimestampActual = date.getTime().toString().substring(0, 10);
    var intDifference = intTimestamp - intTimestampActual;
    var intHoursDivisor = intDifference % (60 * 60);
    var intHours = Math.floor(intDifference / (60 * 60));
    var intMinutesDivisor = intHoursDivisor % (60);
    var intMinutes = Math.floor(intHoursDivisor / (60));
    var intSeconds = intMinutesDivisor;
    intHours = ((intHours < 10) && (intHours >= 0)) ? '0' + intHours : intHours;
    intMinutes = ((intMinutes < 10) && (intMinutes >= 0)) ? '0' + intMinutes : intMinutes;
    intSeconds = ((intSeconds < 10) && (intSeconds >= 0)) ? '0' + intSeconds : intSeconds;
    intGlobalHoursRegressiveCount = intHours;
    intGlobalMinutesRegressiveCount = intMinutes;
    intGlobalSecondsRegressiveCount = intSeconds;
    if ((intHours < 0) || (intMinutes < 0) || (intSeconds < 0)) {
        if (strFunctionExecZero != undefined)
            eval(strFunctionExecZero);
        clearInterval(intGlobalIntervalRegressiveCount);
    } else if (strFunctionExecNoZero != undefined)
        eval(strFunctionExecNoZero);
    return true;
}

/**
 * Retorna um inteiro que identifica a tecla pressionada
 *
 * @param HANDLER de evento de tecla 
 * @return INTEGER
 */
function getIntKeyCode(keyEvent)
{
    var intKeyCode = ((keyEvent.which) ? keyEvent.which : keyEvent.keyCode);
    if (keyEvent.shiftKey)
        intKeyCode += 1000;
    return intKeyCode;
}

/**
 * Retorna o tipo de tecla pressionada
 *
 * @require getIntKeyCode
 * @param INTEGER intKeyCode
 * @return STRING
 */
var intGlobalLastTypeKeyCode = 'unknown';
var intGlobalLastKeyCode = -1;
function getKeyType(intKeyCode)
{
    var strType = 'unknown';
    if (intGlobalLastTypeKeyCode == 'special')
        strType = 'letter';
    else if (intKeyCode == 8)
        strType = 'backspace';
    else if ((intKeyCode == 9) || (intKeyCode == 1009))
        strType = 'tab';
    else if (intKeyCode == 13)
        strType = 'enter';
    else if (intKeyCode == 32)
        strType = 'space';
    else if (((intKeyCode >= 33) && (intKeyCode <= 40)) || ((intKeyCode >= 1033) && (intKeyCode <= 1040)))
        strType = 'position';
    else if (intKeyCode == 46)
        strType = 'delete';
    else if (((intKeyCode >= 48) && (intKeyCode <= 57)) || ((intKeyCode >= 96) && (intKeyCode <= 105)))
        strType = 'number';
    else if (((intKeyCode >= 59) && (intKeyCode <= 90)) || ((intKeyCode >= 1059) && (intKeyCode <= 1090)))
        strType = 'letter';
//    else if (((intKeyCode >= 97) && (intKeyCode <= 122)) || ((intKeyCode >= 1097) && (intKeyCode <= 1122))) 
//        strType = 'letter';
    else if ((intKeyCode >= 112) && (intKeyCode <= 123))
        strType = 'Fn';
    else if ((intKeyCode == 219) || (intKeyCode == 1219) || (intKeyCode == 222) || (intKeyCode == 1222))
        strType = 'special';
    intGlobalLastKeyCode = intKeyCode;
    intGlobalLastTypeKeyCode = strType;
    return strType;
}