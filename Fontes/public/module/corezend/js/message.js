function addMessage(mixMessage)
{
    return ajaxServiceMessage(mixMessage, 'addMessage');
}

function addMessageSuccess(mixMessage)
{
    return ajaxServiceMessage(mixMessage, 'addMessageSuccess');
}

function addMessageError(mixMessage)
{
    return ajaxServiceMessage(mixMessage, 'addMessageError');
}

function addMessageWarning(mixMessage)
{
    return ajaxServiceMessage(mixMessage, 'addMessageWarning');
}

function addMessageNotice(mixMessage)
{
    return ajaxServiceMessage(mixMessage, 'addMessageNotice');
}

function addMessageValidate(mixMessage)
{
    return ajaxServiceMessage(mixMessage, 'addMessageValidate');
}

function ajaxServiceMessage(mixMessage, strMethod)
{
    if ((mixMessage == undefined) || (strMethod == undefined))
        return false;
    if (!isArray(mixMessage))
        mixMessage = new Array(mixMessage);
    var arrUrlParam = new Array();
    arrUrlParam['method'] = strMethod;
    for (var intCount = 0; intCount < mixMessage.length; ++intCount)
        arrUrlParam['message[' + intCount + ']'] = mixMessage[intCount];
    var strUrl = '/message';
    var mixResult = ajaxRequest(strUrl, arrUrlParam, undefined, undefined, undefined, undefined, false, false, true);
    if (mixResult === false)
        return false;
    var messageContainer = getObject('messageContainer');
    if (messageContainer == undefined)
        return false;
    messageContainer.innerHTML += mixResult;
    return true;
}