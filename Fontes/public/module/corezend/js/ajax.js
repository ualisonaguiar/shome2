function ajaxRequest(strUrl, mixUrlParam, strAfterFunction, arrAfterFunctionParam, strMethod, strDataType, booWait, booAsync, booCache)
{
    if (strUrl == undefined)
        return false;
    if (strMethod == undefined)
        strMethod = 'POST';
    if (strDataType == undefined)
        strDataType = 'text';
    if (booWait == undefined)
        booWait = false;
    if (booAsync == undefined)
        booAsync = false;
    if (booCache == undefined)
        booCache = false;
    if (strMethod.toUpperCase() == 'POST') {
        var strNameParamRequest = base64Encode(strUrl + '_' + implode('_', parseArray(mixUrlParam)));
    }
    if ((booWait == true) && (existFunction('openWaitDialog')))
        openWaitDialog();
    strUrl = strGlobalBasePath + strUrl;
    var arrParamAjaxRequest = new Array();
    arrParamAjaxRequest['url'] = strUrl;
    if (mixUrlParam != undefined) {
        var urlParam = new Object();
        if (isArray(mixUrlParam)) {
            for (var mixKey in mixUrlParam) {
                if (mixUrlParam[mixKey] == undefined)
                    continue;
                var strAttributeHierarchy = replaceAll(mixKey, '[]', '');
                /*                eval('urlParam.' + mixKey + ' = mixUrlParam[mixKey];');*/
                var arrAttributeValue = undefined;
                var intPosOpen = strAttributeHierarchy.indexOf('[');
                if ((intPosOpen != -1) && (strAttributeHierarchy.indexOf(']') != -1)) {
                    var strAttribute = strAttributeHierarchy.substr(0, intPosOpen);
                    if (isArray(urlParam[strAttribute]))
                        arrAttributeValue = urlParam[strAttribute];
                }
                urlParam = createAttributeHierarchyIntoObject(strAttributeHierarchy, mixUrlParam[mixKey], urlParam);
                if ((isArray(arrAttributeValue)) && (isArray(urlParam[strAttribute]))) {
                    var arrAttributeValueMerged = arrAttributeValue;
                    var arrUrlParamAttribute = urlParam[strAttribute];
                    for (var intCount = 0; intCount < arrUrlParamAttribute.length; ++intCount) {
                        var mixUrlParamAttribute = arrUrlParamAttribute[intCount];
                        if (mixUrlParamAttribute == undefined)
                            continue;
                        /*                        arrAttributeValueMerged[arrAttributeValueMerged.length] = mixUrlParamAttribute;*/
                        arrAttributeValueMerged[intCount] = mixUrlParamAttribute;
                    }
                    urlParam[strAttribute] = arrAttributeValueMerged;
                }
            }
        }
        arrParamAjaxRequest['data'] = urlParam;
    }
    arrParamAjaxRequest['type'] = strMethod;
    arrParamAjaxRequest['dataType'] = strDataType;
    arrParamAjaxRequest['async'] = booAsync;
    arrParamAjaxRequest['cache'] = booCache;
    /*    if (strDataType.toLowerCase() == 'json') {
     arrParamAjaxRequest['beforeSend'] = function(jqXHR) 
     {
     if ((jqXHR) && (jqXHR.overrideMimeType)) jqXHR.overrideMimeType('application/j-son; charset=UTF-8');
     };
     }*/
    var mixResultAjax = booAsync;
    var ajaxRequest = $.ajax(arrParamAjaxRequest);
    ajaxRequest.fail(
            function (jqXHR, textStatus, errorThrown)
            {
                if ((booWait == true) && (existFunction('closeWaitDialog')))
                    closeWaitDialog();
                var strMessage = 'Ocorreu um erro e a operação não pôde ser realizada!';
                if (existFunction('alertDialog'))
                    alertDialog(strMessage, 'Erro', 350, 150);
                else
                    alert(strMessage);
                mixResultAjax = false;
            }
    );
    if (arrAfterFunctionParam == undefined)
        arrAfterFunctionParam = new Array();
    ajaxRequest.done(
            function (data, textStatus, jqXHR)
            {
                if ((booWait == true) && (existFunction('closeWaitDialog')))
                    closeWaitDialog();
                if (strAfterFunction != undefined)
                    eval('mixResultAjax = ' + strAfterFunction + '(data, arrAfterFunctionParam);');
                if (booAsync === true)
                    mixResultAjax = true;
                else if ((strAfterFunction == undefined) || (mixResultAjax == undefined))
                    mixResultAjax = data;
            }
    );
    return mixResultAjax;
}

function feedSelect(mixInvoker, mixReceiver, strUrl, mixValueReceiver, booWait, booAsync, booCache, strAfterFunction)
{
    if ((mixInvoker == undefined) || (mixReceiver == undefined))
        return false;
    var invoker = getObject(mixInvoker);
    var receiver = getObject(mixReceiver);
    if ((invoker == undefined) || (invoker.id == undefined) || (receiver == undefined))
        return false;
    var arrOption = receiver.childNodes;
    var optionFirst = undefined;
    if ((arrOption.length > 0) && (arrOption[0].value == '')) {
        optionFirst = document.createElement('OPTION');
        optionFirst.value = arrOption[0].value;
        optionFirst.innerHTML = arrOption[0].innerHTML;
    }
    receiver.innerHTML = '';
    if (optionFirst != undefined)
        receiver.appendChild(optionFirst);
    if ((invoker.value == '') || (strUrl == undefined))
        return true;
    var arrUrlParam = new Array();
    arrUrlParam[invoker.id] = invoker.value;
    return ajaxRequest(strUrl, arrUrlParam, 'feedSelectAfterAjax', new Array(receiver, mixValueReceiver, strAfterFunction), undefined, 'json', booWait, booAsync, booCache);
}

function feedSelectAfterAjax(mixData, arrParam)
{
    var receiver = arrParam[0];
    var mixValueReceiver = arrParam[1];
    var strAfterFunction = arrParam[2];
    for (var intCount = 0; intCount < mixData.length; ++intCount) {
        if (mixData[intCount] == undefined)
            continue;
        var option = document.createElement('OPTION');
        option.value = mixData[intCount].value;
        option.innerHTML = mixData[intCount].text;
        if ((mixValueReceiver != undefined) && (mixData[intCount].value == mixValueReceiver))
            option.selected = true;
        receiver.appendChild(option);
    }
    if (strAfterFunction != undefined) {
        eval('var mixResult = ' + strAfterFunction + ';');
        return mixResult;
    }
}

function filterPaginator(mixForm)
{
    var arrValuesForm = getValuesForm(mixForm);
    var strValueFieldForm = '';
    $.each(arrValuesForm, function (intPosicao, arrField) {
        for (var strNameFiled in arrField) {
            if (arrField[strNameFiled] != '') {
                strValueFieldForm += strNameFiled + '&' + base64Encode(arrField[strNameFiled]) + ',';
            }
        }
    });
    paginator = new Paginator();
    mixUrlParam['query'] = strValueFieldForm;
    paginator.showGrid(mixUrlParam['route']);
}

//function filterPaginator(strUrl, mixFo')rm, strReferenceTable, booAllowEmptyFilter, arrIgnoreCheckAllowEmptyFilter, strSortName, strSortOrder, booClearUrlParam, strMessage)
//{
//    if (mixForm == undefined) {
//        var arrForm = document.getElementsByTagName('FORM');
//        if (arrForm.length == 0)
//            return false;
//        mixForm = arrForm[0];
//    }
//    var form = getObject(mixForm);
//    if (form == undefined)
//        return false;
//    if (strUrl == undefined) {
//        form.submit();
//        return true;
//    }
//    if (strReferenceTable == undefined) {
//        var arrTable = getElementsFromAttribute(document.body, 'TABLE', 'summary', 'flexigridTable');
//        if (arrTable.length > 0) {
//            var table = arrTable[0];
//            if ((table.getAttribute('id') != undefined) && (table.getAttribute('id') != ''))
//                strReferenceTable = '#' + table.getAttribute('id');
//        }
//    }
//    if (strReferenceTable == undefined)
//        strReferenceTable = '#tableData';
//    if (booAllowEmptyFilter == undefined)
//        booAllowEmptyFilter = true;
//    if (booClearUrlParam == undefined)
//        booClearUrlParam = true;
//    var arrValuesForm = getValuesForm(mixForm);
//    var arrUrlParam = new Array();
//    for (var intCount = 0; intCount < arrValuesForm.length; ++intCount) {
//        loopValuesForm: for (var mixKey in arrValuesForm[intCount]) {
///*            if ((arrValuesForm[intCount][mixKey] == undefined) || (arrValuesForm[intCount][mixKey] == ''))*/
//            if (arrValuesForm[intCount][mixKey] == undefined)
//                continue;
//            if (arrIgnoreCheckAllowEmptyFilter != undefined) {
//                for (var intCount2 = 0; intCount2 < arrIgnoreCheckAllowEmptyFilter.length; ++intCount2) {
//                    if (arrIgnoreCheckAllowEmptyFilter[intCount2] == undefined)
//                        continue;
//                    var elementIgnore = getObject(arrIgnoreCheckAllowEmptyFilter[intCount2][0]);
//                    var strValueIgnore = arrIgnoreCheckAllowEmptyFilter[intCount2][1];
//                    if (((elementIgnore == undefined) || (mixKey === elementIgnore.getAttribute('id'))) && (arrValuesForm[intCount][mixKey] === strValueIgnore))
//                        continue loopValuesForm;
//                }
//            }
//            arrUrlParam[mixKey] = arrValuesForm[intCount][mixKey];
//        }
//    }
//    var booExistsFilter = false;
//    for (var mixKey in arrUrlParam) {
//        if (arrUrlParam[mixKey] != '') {
//            booExistsFilter = true;
//            if (booClearUrlParam !== true)
//                break;
//        } else if (booClearUrlParam === true)
//            delete arrUrlParam[mixKey];
//    }
//    if ((booAllowEmptyFilter === false) && (booExistsFilter == false)) {
//        if (strMessage == undefined)
//            strMessage = 'Informe pelo menos um filtro para pesquisa.';
//        if (existFunction('alertDialog'))
//            alertDialog(strMessage, 'Alerta', 350, 150);
//        else
//            alert(strMessage);
//        return false;
//    }
//    setJsonParamIntoInputHidden(arrUrlParam);
///*    return ajaxRequest(strUrl, arrUrlParam, 'filterPaginatorAfterAjax', new Array(strReferenceTable, strSortName, strSortOrder));*/
//    return filterPaginatorAfterAjax('ok', new Array(strReferenceTable, strSortName, strSortOrder));
//}

function filterPaginatorAfterAjax(mixData, arrParam)
{
    if (mixData.toString().toLowerCase() == 'ok') {
        var strReferenceTable = arrParam[0];
        var strSortName = arrParam[1];
        var strSortOrder = arrParam[2];
        if (strSortName == undefined)
            $(strReferenceTable).flexReload();
        else {
            var arrSortedTitle = getElementsFromAttribute(document.body, 'TH', 'class', 'sorted');
            if (arrSortedTitle.length != 0)
                $(strReferenceTable).flexReload();
            else {
                if (strSortOrder == undefined)
                    strSortOrder = 'asc';
                $(strReferenceTable).flexOptions({sortname: strSortName});
                $(strReferenceTable).flexOptions({sortorder: strSortOrder});
                $(strReferenceTable).flexReload();
                var arrElement = getElementsFromAttribute(document.body, 'TH', 'abbr', strSortName);
                if (arrElement.length > 0) {
                    var th = arrElement[0];
                    th.className = 'sorted';
                    arrElement = th.getElementsByTagName('DIV');
                    if (arrElement.length > 0) {
                        var div = arrElement[0];
                        div.className = 's' + strSortOrder.toString().toLowerCase();
                    }
                }
            }
        }
    }
    else {
        if (existFunction('alertDialog'))
            alertDialog(mixData.toString(), 'Alerta', 450, 300);
        else
            alert(mixData.toString());
    }
}

function ajaxSubmitForm(mixForm, strAfterFunction, arrAfterFunctionParam, strMethod, strDataType, booWait, booAsync, booCache, strAfterFunctionComplete, arrAfterFunctionCompleteParam)
{
    if (mixForm == undefined)
        return false;
    var form = getObject(mixForm);
    if (form == undefined)
        return false;
    if (arrAfterFunctionParam == undefined)
        arrAfterFunctionParam = new Array();
    if (strMethod == undefined)
        strMethod = 'POST';
    if (strDataType == undefined)
        strDataType = null;
    if (booWait == undefined)
        booWait = true;
    if (booAsync == undefined)
        booAsync = false;
    if (booCache == undefined)
        booCache = false;
    if (arrAfterFunctionCompleteParam == undefined)
        arrAfterFunctionCompleteParam = new Array();
    if ((booWait == true) && (existFunction('openWaitDialog')))
        openWaitDialog();
    form.setAttribute('method', strMethod);
    if (document.all) {
        var arrSelectReplace = new Array();
        var arrHiddenReplace = new Array();
        var arrSelect = form.getElementsByTagName('SELECT');
        for (var intCount = 0; intCount < arrSelect.length; ++intCount) {
            var select = arrSelect[intCount];
            if ((select == undefined) || (!isEmptyAttribute(select, 'multiple')) || (isEmptyAttribute(select, 'name')) /*|| (select.getAttribute('name') == 'rp')*/)
                continue;
            var strId = (isEmptyAttribute(select, 'id')) ? select.getAttribute('name') : select.getAttribute('id');
            var selectValue = getObject(strId);
            if (selectValue == undefined)
                continue;
            arrSelectReplace[arrSelectReplace.length] = select;
            arrHiddenReplace[arrHiddenReplace.length] = createHiddenIntoRepository(undefined, strId, select.getAttribute('name'), selectValue.value);
        }
        var intLength = arrSelectReplace.length;
        for (var intCount = 0; intCount < intLength; ++intCount) {
            if ((arrHiddenReplace[intCount] == undefined) || (arrSelectReplace[intCount] == undefined))
                continue;
            try {
                form.replaceChild(arrHiddenReplace[intCount], arrSelectReplace[intCount]);
            } catch (exception) {
                continue;
            }
        }
        if ((!isEmptyAttribute(form, 'name')) || (!isEmptyAttribute(form, 'id'))) {
            var strFormName = (!isEmptyAttribute(form, 'name')) ? form.getAttribute('name') : undefined;
            var strFormId = (!isEmptyAttribute(form, 'id')) ? form.getAttribute('id') : undefined;
            var arrForm = document.getElementsByTagName('FORM');
            var booExists = false;
            for (var intCount = 0; intCount < arrForm.length; ++intCount) {
                var formIntern = arrForm[intCount];
                if (formIntern == undefined)
                    continue;
                var strFormInternName = (!isEmptyAttribute(formIntern, 'name')) ? formIntern.getAttribute('name') : undefined;
                var strFormInternId = (!isEmptyAttribute(formIntern, 'id')) ? formIntern.getAttribute('id') : undefined;
                if ((strFormName == strFormInternName) && (strFormId == strFormInternId)) {
                    booExists = true;
                    break;
                }
            }
            if (!booExists) {
                form.style.display = 'none';
                document.body.appendChild(form);
            }
        }
    }
    var mixResultAjax = booAsync;
    $(form).ajaxForm(
            {
                type: strMethod,
                dataType: strDataType,
                async: booAsync,
                cache: booCache,
                complete: function (jqXHR) {
                    /*                    console.log(jqXHR.responseText);*/
                    if ((booWait == true) && (existFunction('closeWaitDialog')))
                        closeWaitDialog();
                    if (strAfterFunctionComplete != undefined)
                        eval('mixResultAjax = ' + strAfterFunctionComplete + '(jqXHR, arrAfterFunctionCompleteParam);');
                    if (booAsync === true)
                        mixResultAjax = true;
                    else if ((strAfterFunctionComplete == undefined) || (mixResultAjax == undefined))
                        mixResultAjax = jqXHR;
                },
                error: function () {
                    var strMessage = 'Ocorreu um erro e a operação não pôde ser realizada!';
                    if (existFunction('alertDialog'))
                        alertDialog(strMessage, 'Erro', 350, 150);
                    else
                        alert(strMessage);
                    mixResultAjax = false;
                },
                success: function (data, textStatus, jqXHR) {
                    if (strAfterFunction != undefined)
                        eval('mixResultAjax = ' + strAfterFunction + '(data, arrAfterFunctionParam);');
                    if (booAsync === true)
                        mixResultAjax = true;
                    else if ((strAfterFunction == undefined) || (mixResultAjax == undefined))
                        mixResultAjax = data;
                }
            }
    );
    $(form).submit();
    return mixResultAjax;
}

function ajaxUpload(mixInputFile, strAfterFunction, arrAfterFunctionParam, strUrl, mixForm, booWait, booAsync, booCache)
{
    if (mixInputFile == undefined)
        return false;
    var inputFile = getObject(mixInputFile);
    if (inputFile == undefined)
        return false;
    if (inputFile.value == '') {
        var strMessage = 'É necessário selecionar algum arquivo para realizar a operação!';
        if (existFunction('alertDialog'))
            alertDialog(strMessage, 'Alerta', 350, 150);
        else
            alert(strMessage);
        return true;
    }
    if (arrAfterFunctionParam == undefined)
        arrAfterFunctionParam = new Array();
    if (mixForm == undefined) {
        var form = document.getElementById('formAjaxUpload');
        if (form == undefined) {
            form = document.createElement('FORM');
            form.setAttribute('id', 'formAjaxUpload');
            form.setAttribute('method', 'POST');
            form.setAttribute('enctype', 'multipart/form-data');
            form.style.display = 'none';
            document.body.appendChild(form);
        }
    } else {
        var form = getObject(mixForm);
        if (form == undefined)
            return false;
    }
    if (strUrl != undefined) {
        strUrl = strGlobalBasePath + strUrl;
        form.setAttribute('action', strUrl);
    }
    var parentNode = inputFile.parentNode;
    if (((parentNode.tagName + '') != 'SPAN') || (parentNode.getAttribute('name') != 'spanInputFile')) {
        span = document.createElement('SPAN');
        span.setAttribute('name', 'spanInputFile');
        parentNode.replaceChild(span, inputFile);
        span.appendChild(inputFile);
    } else
        span = parentNode;
    span.innerHTML = '';
    span.appendChild(inputFile.cloneNode(true));
    form.appendChild(inputFile);
    return ajaxSubmitForm(form, undefined, undefined, undefined, undefined, booWait, booAsync, booCache, 'ajaxUploadAfterAjax', new Array(inputFile, span, strAfterFunction, arrAfterFunctionParam));
}

function ajaxUploadAfterAjax(jqXHR, arrParam)
{
    var inputFile = arrParam[0];
    var span = arrParam[1];
    var strAfterFunction = arrParam[2];
    var arrAfterFunctionParam = arrParam[3];
    span.innerHTML = '';
    span.appendChild(inputFile);
    if (strAfterFunction != undefined)
        eval(strAfterFunction + '(jqXHR, arrAfterFunctionParam);');
}