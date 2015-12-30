var arrDialog;
function openDialog(mixText, strTitle, intWidth, intHeight, arrButton, booModal, booResizable, booClose, strEvalOpen, strName)
{
    if (mixText == undefined)
        mixText = '';
    if (intWidth == undefined)
        intWidth = 500;
    if (intHeight == undefined)
        intHeight = 300;
    if (booModal == undefined)
        booModal = true;
    if (booResizable == undefined)
        booResizable = true;
    if (booClose == undefined)
        booClose = true;
    if (strEvalOpen == undefined)
        strEvalOpen = '';
    strEvalOpen = 'setDialogGlobal(this, strName);' + strEvalOpen;
    var arrParam = new Array();
    if (strTitle != undefined)
        arrParam['title'] = strTitle;
    if (booClose) {
        arrParam['closeText'] = 'fechar';
        arrParam['open'] = function(event, ui) {
            eval(strEvalOpen);
        }
    } else {
        arrParam['closeOnEscape'] = false;
        arrParam['open'] = function(event, ui) {
            eval(strEvalOpen);
            $('.ui-dialog-titlebar-close', $(this).parent()).hide();
        }
    }
    arrParam['width'] = intWidth;
    arrParam['height'] = intHeight;
    arrParam['modal'] = booModal;
    arrParam['resizable'] = booResizable;
    if (isArray(arrButton))
        arrParam['buttons'] = arrButton;
    if (!isObject(mixText))
        mixText = '<div>' + mixText + '</div>';
    try {
        $(mixText).dialog(arrParam);
    } catch (exception) {

    }
    return;
}

function confirmDialog(mixText, strTitle, intWidth, intHeight, strEvalOk, strEvalCancel, booModal, booResizable, strName)
{
    var arrButton = addButton('OK', strEvalOk);
    arrButton = addButton('Cancelar', strEvalCancel, arrButton);
    return openDialog(mixText, strTitle, intWidth, intHeight, arrButton, booModal, booResizable, undefined, undefined, strName);
}

function yesNoDialog(mixText, strTitle, intWidth, intHeight, strEvalYes, strEvalNo, booModal, booResizable, strName)
{
    var arrButton = addButton('Sim', strEvalYes);
    arrButton = addButton('Não', strEvalNo, arrButton);
    return openDialog(mixText, strTitle, intWidth, intHeight, arrButton, booModal, booResizable, undefined, undefined, strName);
}

function clearDialog(mixText, strTitle, intWidth, intHeight, booModal, booResizable, strName)
{
    return openDialog(mixText, strTitle, intWidth, intHeight, undefined, booModal, booResizable, undefined, undefined, strName);
}

function alertDialog(mixText, strTitle, intWidth, intHeight, strEvalOk, booModal, booResizable, strName)
{
    var arrButton = addButton('OK', strEvalOk);
    return openDialog(mixText, strTitle, intWidth, intHeight, arrButton, booModal, booResizable, undefined, undefined, strName);
}

function openWaitDialog(mixText, strTitle, intWidth, intHeight, strName)
{
    if (mixText == undefined)
        mixText = '<br />Aguarde a realização das devidas operações...<br /><br /><img src="' + strGlobalBasePath + '/module/corezend/img/progress.gif" />';
    mixText = '<div id="divOpenWaitDialog" style="text-align: center;">' + ((!isObject(mixText)) ? mixText : mixText.innerHTML) + '</div>';
    if (strTitle == undefined)
        strTitle = 'Aguarde';
    if (intWidth == undefined)
        intWidth = 250;
    if (intHeight == undefined)
        intHeight = 175;
    if (strName == undefined)
        strName = 'waitDialog';
    return openDialog(mixText, strTitle, intWidth, intHeight, undefined, undefined, undefined, false, undefined, strName);
}

function closeWaitDialog(strName)
{
    if (strName == undefined)
        strName = 'waitDialog';
    closeDialog(strName);
}

function closeDialog(strName)
{
    if (strName != undefined) {
        var dialog = getDialogGlobal(strName);
        if (dialog == undefined)
            return false;
        $(dialog).dialog('close');
        setDialogGlobal(undefined, strName);
    } else {
        arrDialog = getDialogGlobal();
        for (var mixKey in arrDialog) {
            var dialog = arrDialog[mixKey];
            if ((dialog == undefined) || ($(dialog).dialog('isOpen') == false))
                continue;
            $(dialog).dialog('close');
            setDialogGlobal(undefined, mixKey);
        }
    }
    clearDialogGlobal();
}

function getDialogGlobal(mixKey)
{
    if (arrDialog == undefined)
        arrDialog = new Array();
    return (mixKey == undefined) ? arrDialog : arrDialog[mixKey];
}

function setDialogGlobal(dialog, strName)
{
    arrDialog = getDialogGlobal();
    arrDialog[(strName == undefined) ? arrDialog.length : strName] = dialog;
    arrDialog = clearDialogGlobal();
}

function clearDialogGlobal()
{
    arrDialog = getDialogGlobal();
    var arrResult = new Array();
    for (mixKey in arrDialog) {
        if ((arrDialog[mixKey] == undefined) || ($(arrDialog[mixKey]).dialog('isOpen') == false))
            continue;
        arrResult[mixKey] = arrDialog[mixKey];
    }
    return arrResult;
}

function addButton(strText, strEval, arrButton)
{
    if (arrButton == undefined)
        arrButton = new Array();
    var intKey = arrButton.length;
    arrButton[intKey] = new Array();
    arrButton[intKey]['text'] = strText;
    arrButton[intKey]['click'] = function() {
        eval(strEval);
        $(this).dialog('close');
    };
    return arrButton;
}