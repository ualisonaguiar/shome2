/**
 * Valida um CPF
 *
 * @param STRING strCpf
 * @param BOOLEAN booShowValidate
 * @return BOOLEAN
 */
function validateCpf(strCpf, booShowValidate)
{
    if (booShowValidate == undefined)
        booShowValidate = true;
    strCpf = replaceAll(strCpf, '.', '');
    strCpf = replaceAll(strCpf, '-', '');
    strCpf = replaceAll(strCpf, '/', '');
    var intDigitosIguais = 1;
    if (strCpf.length < 11) {
        if (booShowValidate === true) {
            if (existFunction('alertDialog'))
                alertDialog('CPF inválido.', 'Validação', 200, 150);
            else
                alert('CPF inválido.');
        }
        return false;
    }
    for (var intCount = 0; intCount < strCpf.length - 1; ++intCount) {
        if (strCpf.charAt(intCount) != strCpf.charAt((intCount + 1))) {
            intDigitosIguais = 0;
            break;
        }
    }
    if (!intDigitosIguais) {
        var intNumeros = strCpf.substring(0, 9);
        var intDigitos = strCpf.substring(9);
        var intSoma = 0;
        for (intCount = 10; intCount > 1; --intCount)
            intSoma += intNumeros.charAt((10 - intCount)) * intCount;
        var intResultado = intSoma % 11 < 2 ? 0 : 11 - intSoma % 11;
        if (intResultado != intDigitos.charAt(0)) {
            if (booShowValidate === true) {
                if (existFunction('alertDialog'))
                    alertDialog('CPF inválido.', 'Validação', 200, 150);
                else
                    alert('CPF inválido.');
            }
            return false;
        }
        intNumeros = strCpf.substring(0, 10);
        intSoma = 0;
        for (intCount = 11; intCount > 1; --intCount)
            intSoma += intNumeros.charAt((11 - intCount)) * intCount;
        intResultado = intSoma % 11 < 2 ? 0 : 11 - intSoma % 11;
        if (intResultado != intDigitos.charAt(1)) {
            if (booShowValidate === true) {
                if (existFunction('alertDialog'))
                    alertDialog('CPF inválido.', 'Validação', 200, 150);
                else
                    alert('CPF inválido.');
            }
            return false;
        }
        return true;
    } else {
        if (booShowValidate === true) {
            if (existFunction('alertDialog'))
                alertDialog('CPF inválido.', 'Validação', 200, 150);
            else
                alert('CPF inválido.');
        }
        return false;
    }
}

/**
 * Valida um CNPJ
 *
 * @param STRING strCnpj
 * @param BOOLEAN booShowValidate
 * @return BOOLEAN
 */
function validateCnpj(strCnpj, booShowValidate)
{
    if (booShowValidate == undefined)
        booShowValidate = true;
    strCnpj = replaceAll(strCnpj, '.', '');
    strCnpj = replaceAll(strCnpj, '-', '');
    strCnpj = replaceAll(strCnpj, '/', '');
    var intDigitosIguais = 1;
    if (strCnpj.length != 14) {
        if (booShowValidate === true) {
            if (existFunction('alertDialog'))
                alertDialog('CNPJ inválido.', 'Validação', 200, 150);
            else
                alert('CNPJ inválido.');
        }
        return false;
    }
    for (var intCount = 0; intCount < strCnpj.length - 1; ++intCount) {
        if (strCnpj.charAt(intCount) != strCnpj.charAt((intCount + 1))) {
            intDigitosIguais = 0;
            break;
        }
    }
    if (!intDigitosIguais) {
        var intTamanho = strCnpj.length - 2;
        var intNumeros = strCnpj.substring(0, intTamanho);
        var intDigitos = strCnpj.substring(intTamanho);
        var intSoma = 0;
        var intPos = intTamanho - 7;
        for (intCount = intTamanho; intCount >= 1; --intCount) {
            intSoma += intNumeros.charAt((intTamanho - intCount)) * intPos--;
            if (intPos < 2)
                intPos = 9;
        }
        var intResultado = intSoma % 11 < 2 ? 0 : 11 - intSoma % 11;
        if (intResultado != intDigitos.charAt(0)) {
            if (booShowValidate === true) {
                if (existFunction('alertDialog'))
                    alertDialog('CNPJ inválido.', 'Validação', 200, 150);
                else
                    alert('CNPJ inválido.');
            }
            return false;
        }
        intTamanho = intTamanho + 1;
        intNumeros = strCnpj.substring(0, intTamanho);
        intSoma = 0;
        intPos = intTamanho - 7;
        for (intCount = intTamanho; intCount >= 1; --intCount) {
            intSoma += intNumeros.charAt(intTamanho - intCount) * intPos--;
            if (intPos < 2)
                intPos = 9;
        }
        intResultado = intSoma % 11 < 2 ? 0 : 11 - intSoma % 11;
        if (intResultado != intDigitos.charAt(1)) {
            if (booShowValidate === true) {
                if (existFunction('alertDialog'))
                    alertDialog('CNPJ inválido.', 'Validação', 200, 150);
                else
                    alert('CNPJ inválido.');
            }
            return false;
        }
        return true;
    } else {
        if (booShowValidate === true) {
            if (existFunction('alertDialog'))
                alertDialog('CNPJ inválido.', 'Validação', 200, 150);
            else
                alert('CNPJ inválido.');
        }
        return false;
    }
}

/**
 * Valida um PIS/PASEP
 *
 * @param STRING strPisPasep
 * @param BOOLEAN booShowValidate
 * @return BOOLEAN
 */
function validatePisPasep(strPisPasep, booShowValidate)
{
    if ((strPisPasep == '') || (strPisPasep == undefined))
        return false;
    if (booShowValidate == undefined)
        booShowValidate = true;
    strPisPasep = replaceAll(strPisPasep, '.', '');
    strPisPasep = replaceAll(strPisPasep, '-', '');
    var strKey = '3298765432';
    var intTotal = 0;
    var intResto = 0;
    var strResto = '';
    var intDigitosIguais = 1;
    for (var intCount = 0; intCount < strPisPasep.length - 1; ++intCount) {
        if (strPisPasep.charAt(intCount) != strPisPasep.charAt((intCount + 1))) {
            intDigitosIguais = 0;
            break;
        }
    }
    if (!intDigitosIguais) {
        for (var intCount = 0; intCount <= 9; ++intCount) {
            var intResultado = (strPisPasep.slice(intCount, (intCount + 1))) * (strKey.slice(intCount, (intCount + 1)));
            intTotal = intTotal + intResultado;
        }
        intResto = (intTotal % 11);
        if (intResto != 0)
            intResto = (11 - intResto);
        if ((intResto == 10) || (intResto == 11)) {
            strResto = intResto + '';
            intResto = strResto.slice(1, 2);
        }
        if (intResto != (strPisPasep.slice(10, 11))) {
            if (booShowValidate === true) {
                var strMessage = 'PIS/PASEP inexistente!';
                if (existFunction('alertDialog'))
                    alertDialog(strMessage, 'Validação', 200, 150);
                else
                    alert(strMessage);
            }
            return false;
        }
        return true;
    } else {
        if (booShowValidate === true) {
            if (existFunction('alertDialog'))
                alertDialog('PIS/PASEP inexistente!', 'Validação', 200, 150);
            else
                alert('PIS/PASEP inexistente!');
        }
        return false;
    }
}

/**
 * Valida se uma data eh bissexto
 *
 * @param STRING strDate
 * @param BOOLEAN booShowValidate
 * @return BOOLEAN
 */
function validateDateBissexto(strDate, booShowValidate)
{
    if ((strDate == '') || (strDate == undefined))
        return false;
    if (booShowValidate == undefined)
        booShowValidate = true;
    var arrDate = strDate.split(/[/-]/);
    var intYear = parseInt(arrDate[2]);
    var booValidate = true;
    if ((parseInt(arrDate[1]) == 2) && (parseInt(arrDate[0]) > 28))
        booValidate = ((intYear % 4 == 0) && ((intYear % 100 != 0) || (intYear % 400 == 0)));
    if ((!booValidate) && (booShowValidate === true)) {
        if (existFunction('alertDialog'))
            alertDialog('Data inválida!', 'Validação', 200, 150);
        else
            alert('Data inválida!');
    }
    return booValidate;
}

function validatePhone(strPhone, booShowValidate, inputPhone)
{
    if ((strPhone == '') || (strPhone == undefined) || (inputPhone == undefined) || (!isObject(inputPhone)))
        return false;
    if (inputPhone.context != undefined)
        inputPhone = inputPhone.context;
    var selectDdd = getObject(strGlobalPrefixDdd + inputPhone.getAttribute('id'));
    if (selectDdd == undefined)
        return true;
    var intDdd = selectDdd.value;
    if (intDdd == '')
        return true;
    var intPhone = replaceAll(strPhone, '-', '');
    if (booShowValidate == undefined)
        booShowValidate = true;
    var arrDdd = new Array();
    var arrOption = selectDdd.getElementsByTagName('OPTION');
    for (var intCount = 0; intCount < arrOption.length; ++intCount) {
        var mixValue = arrOption[intCount].value;
        if (mixValue == '')
            continue;
        arrDdd[arrDdd.length] = parseInt(arrOption[intCount].value);
    }
    eval('var arrDdd9Digit = [11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 24, 27, 28];');
    var intDigit = 8;
    for (var intCount = 0; intCount < arrDdd9Digit.length; ++intCount) {
        if (intDdd == arrDdd9Digit[intCount]) {
            intDigit = 9;
            break;
        }
    }
    var booValidate = (intPhone.length == intDigit);
    if ((!booValidate) && (booShowValidate === true)) {
        if (existFunction('alertDialog'))
            alertDialog('Formato inválido!', 'Validação', 200, 150);
        else
            alert('Formato inválido!');
    }
    return booValidate;
}

function checkValue(strValue, strType, booShowValidate, input)
{
    var strRegex = undefined,
            booValidacao = true;
    switch (strType) {
        case 'hour':
        {
            strRegex = /^\d{2}:\d{2}/;
            break;
        }
        case 'date':
        {
            strRegex = /^(?:(?:[0-2]\d|3[0-1])\/(?:01|03|05|07|08|10|12)|(?:[0-2]\d|30)\/(?:04|06|09|11)|(?:[0-1]\d|2[0-9])\/02)\/(?:19\d{2}|20\d{2})/;
            break;
        }
        case 'dateTime':
        {
            strRegex = /^(?:(?:[0-2]\d|3[0-1])\/(?:01|03|05|07|08|10|12)|(?:[0-2]\d|30)\/(?:04|06|09|11)|(?:[0-1]\d|2[0-9])\/02)\/(?:19\d{2}|20\d{2}) \d{2}:\d{2}/;
            break;
        }
        case 'cpf':
        {
            strRegex = /\d{3}.\d{3}.\d{3}-\d{2}/;
            break;
        }
        case 'cnpj':
        {
            strRegex = /\d\d\.\d\d\d\.\d\d\d\/\d\d\d\d\-\d\d/;
            break;
        }
        case 'pispasep':
        {
            strRegex = /\d{3}.\d{5}.\d{2}-\d{1}/;
            break;
        }
        case 'cpfCnpj':
        {
            strRegex = /^\d+$/;
            break;
        }
        case 'cep':
        {
            strRegex = /\d\d\d\d\d\-\d\d\d/;
            break;
        }
        case 'integer':
        case 'phone':
        {
            strRegex = /^\d+$/;
            break;
        }
        case 'phone8':
        {
            strRegex = /\d\d\d\d\-\d\d\d\d/;
            break;
        }
        case 'phone9':
        {
            strRegex = /\d\d\d\d\d\-\d\d\d\d/;
            break;
        }
        case 'email':
        {
            if (strValue == '')
                return true;
            strRegex = /^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            break;
        }
        default:
        {
            return false;
            break;
        }
    }
    if (strValue.match(strRegex)) {
        switch (strType) {
            case 'cpf':
            {
                booValidacao = validateCpf(strValue, booShowValidate);
                break;
            }
            case 'cnpj':
            {
                booValidacao = validateCnpj(strValue, booShowValidate);
                break;
            }
            case 'pispasep':
            {
                booValidacao = validatePisPasep(strValue, booShowValidate);
                break;
            }
            case 'date':
            case 'dateTime':
            {
                booValidacao = validateDateBissexto(strValue, booShowValidate);
                break;
            }
            case 'phone8':
            case 'phone9':
            {
                booValidacao = validatePhone(strValue, booShowValidate, input);
                break;
            }
        }
        if (!booValidacao) {
            input.value = '';
        }
    } else {
        if (booShowValidate === true) {
            switch (strType) {
                case 'date':
                case 'dateTime':
                {
                    var strMessage = 'Data inválida!';
                    break;
                }
                case 'email':
                {
                    var strMessage = 'e-Mail inválido!';
                    break;
                }
                default:
                {
                    var strMessage = 'Formato inválido!';
                    break;
                }
            }
            if (existFunction('alertDialog')) {
                var strEval = (input.getAttribute('id') != '') ? 'setTimeout(\'document.getElementById("' + input.getAttribute('id') + '").focus();\', 100);' : '';
                alertDialog(strMessage, 'Validação', 200, 150, strEval);
                input.value = '';
            } else {
                alert(strMessage);
                input.value = '';
            }
        }
    }
    return booValidacao;
}

function validateValueMask(input, strMask, booShowValidate, strType)
{
    if (!isObject(input))
        input = getObject(input);
    if (!isObject(input))
        return false;
    if (strMask == undefined)
        strMask = '';
    if (strMask == '999.999.999-99')
        strType = 'cpf';
    else if (strMask == '99.999.999/9999-99')
        strType = 'cnpj';
    else if (strMask == '99/99/9999')
        strType = 'date';
    else if (strMask == '99/99/9999 99:99')
        strType = 'dateTime';
    else if (strMask == '9999-9999')
        strType = 'phone8';
    else if (strMask == '99999-9999')
        strType = 'phone9';
    else if (strMask == '@.')
        strType = 'email';
    if (strType == undefined)
        return false;
    var mixValue = undefined;
    var booVal = false;
    try {
        mixValue = input.val();
        booVal = true;
    } catch (exception) {
        mixValue = input.value;
    }
    if (!checkValue(mixValue, strType, booShowValidate, input)) {
        if (strMask.indexOf('9') != -1) {
            var strValue = replaceAll(strMask, '9', '_');
            if (booVal)
                input.val(strValue);
            else
                input.value = strValue;
        }
        ;
        return false;
    }
    return true;
}