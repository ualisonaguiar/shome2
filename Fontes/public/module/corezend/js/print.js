/**
 * Imprime determinado texto
 *
 * @param STRING strMessage
 * @return BOOLEAN
 */
var strGlobalMessage = '';
function printMessage(strMessage)
{
    if (strMessage == undefined)
        return false;
    var strIdIframe = 'iframeToPrintMessage';
    strGlobalMessage = strMessage;
    var iframeToPrint = document.getElementById(strIdIframe);
    if (iframeToPrint == undefined) {
        var strHtmlIframe = "<IFRAME frameborder='0' id='" + strIdIframe + "' name='" + strIdIframe + "' style='width:0px; height:0px; border:0px; float:left;'></IFRAME>";
        document.body.innerHTML = strHtmlIframe + document.body.innerHTML;
        var iframeToPrint = document.getElementById(strIdIframe);
        setTimeout('printMessage(strGlobalMessage);', 100);
        return false;
    }
    eval('parent.' + strIdIframe + '.document.body.innerHTML = "";');
    if (document.all) {
        eval('parent.' + strIdIframe + '.document.body.innerHTML = strGlobalMessage;');
        setTimeout("frames['" + strIdIframe + "'].focus(); frames['" + strIdIframe + "'].print();", 500);
    } else {
        eval('parent.document.getElementById("' + strIdIframe + '").contentDocument.body.innerHTML = strGlobalMessage;');
        setTimeout("frames['" + strIdIframe + "'].print();", 500);
    }
    return true;
}