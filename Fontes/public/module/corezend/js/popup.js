/**
 * Abre uma janela popup com dimensoes de tela cheia
 * 
 * @param STRING strUrl
 * @param STRING strWindowName
 * @param STRING strJsExecOnClose
 * @return MIX
 */
function popupFull(strUrl, strWindowName, strJsExecOnClose)
{
    var strComplement = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=no,copyhistory=1,width=' + screen.availWidth + ',height=' + screen.availHeight + ',top=0,left=0';
    return popup(strUrl, strWindowName, strComplement, strJsExecOnClose);
}

/**
 * Abre uma janela popup
 * 
 * @param STRING strUrl
 * @param STRING strWindowName
 * @param STRING strComplement
 * @param STRING strJsExecOnClose
 * @return MIX
 */
function popup(strUrl, strWindowName, strComplement, strJsExecOnClose)
{
    if ((strUrl == undefined) || (strWindowName == undefined))
        return false;
    if (strComplement == undefined)
        strComplement = 'scrollbars=yes,resizable=yes,width=1017,height=460';
    var windowOpen = window.open(strUrl, strWindowName, strComplement);
    checkPopupExists(windowOpen, strJsExecOnClose);
    try {
        windowOpen.focus(windowOpen.name);
    } catch (exception) {

    }
    return windowOpen;
}

/**
 * Abre uma janela popup modal
 * 
 * @param STRING strUrl
 * @param STRING strWindowName
 * @param STRING strComplement
 * @param STRING strJsExecOnClose
 * @return MIX
 */
function popupModal(strUrl, strWindowName, strComplement, strJsExecOnClose)
{
    var windowOpen = popup(strUrl, strWindowName, strComplement, strJsExecOnClose);
    if (!windowOpen)
        return false;
//    openBackground();
    return true;
}

var intGlobalIntervalPopup;
var windowGlobalPopup;
var strGlobalJsExecOnClosePopup;
function checkPopupExists(windowOpen, strJsExecOnClose)
{
    if ((windowOpen == undefined) || (!isObject(windowOpen)))
        return false;
    intGlobalIntervalPopup = setInterval('checkPopupExistsInterval()', 1000);
    windowGlobalPopup = windowOpen;
    strGlobalJsExecOnClosePopup = strJsExecOnClose;
    return true;
}

function checkPopupExistsInterval()
{
    try {
        var strHref = windowGlobalPopup.location.href;
        if (strHref == undefined)
            throw 'Exception';
    }
    catch (exception) {
        if (intGlobalIntervalPopup != undefined) {
            clearInterval(intGlobalIntervalPopup);
//            closeBackground();
            if (strGlobalJsExecOnClosePopup != undefined)
                eval(strGlobalJsExecOnClosePopup);
            intGlobalIntervalPopup = null;
            windowGlobalPopup = null;
            strGlobalJsExecOnClosePopup = null;
        }
    }
    return true;
}