/**
 * Confere se o parametro e externo do javascript
 *
 * @param OBJECT element
 * @return BOOLEAN
 */
function isAlien(element)
{
    return isObject(element) && typeof element.constructor != 'function';
}

/**
 * Confere se o parametro enviado e um array
 *
 * @param MIX array
 * @return BOOLEAN
 */
function isArray(array)
{
    return isObject(array) && array.constructor == Array;
}

/**
 * Confere se o objeto enviado e um boleano
 *
 * @param MIX boolean
 * @return BOOLEAN
 */
function isBoolean(boolean)
{
    return typeof boolean == 'boolean';
}

/**
 * Confere se o objeto enviado e vazio
 *
 * @param OBJECT element
 * @return BOOLEAN
 */
function isEmpty(element)
{
    var strProperty, mixValue;
    if (isObject(element)) {
        for (strProperty in element) {
            mixValue = element[strProperty];
            if ((isUndefined(mixValue)) && (isFunction(mixValue)))
                return false;
        }
    }
    return true;
}

/**
 * Confere se o parametro enviado e uma funcao
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function isFunction(mixElement)
{
    return typeof mixElement == 'function';
}

/**
 * Confere se existe funcao com o nome informado
 *
 * @param STRING strNameFunction
 * @return BOOLEAN
 */
function existFunction(strNameFunction)
{
    return (window[strNameFunction] != undefined) ? isFunction(window[strNameFunction]) : false;
}

/**
 * Confere se o parametro enviado e nulo
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function isNull(mixElement)
{
    return typeof mixElement == 'object' && !mixElement;
}

/**
 * Confere se o parametro enviado e um numero
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function isNumber(mixElement)
{
    return typeof mixElement == 'number' && isFinite(mixElement);
}

/**
 * Confere se o parametro enviado e numerico
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function isNumeric(mixElement)
{
    var strWhitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixElement === 'number' || (typeof mixElement === 'string' && strWhitespace.indexOf(mixElement.slice(-1)) === -1)) && mixElement !== '' && !isNaN(mixElement);
}

/**
 * Confere se o elemento enviado e um objeto
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function isObject(mixElement)
{
    return (mixElement && typeof mixElement == 'object') || isFunction(mixElement);
}

/**
 * Confere se o elemento enviado e um texto
 *
 * @param MIX mixElement
 * @return BOOLEAN
 */
function isString(mixElement)
{
    return typeof mixElement == 'string';
}

/**
 * Confere se o elemento enviado e indefinido
 *
 * @param MIX  mixElement
 * @return BOOLEAN
 */
function isUndefined(mixElement)
{
    return typeof mixElement == 'undefined';
}

/**
 * Insere elementos em outro (tratando erro no ie principalmente com o innerHTML para tbody)
 *
 * @param MIX mixRepository
 * @param STRING strText
 * @param BOOLEAN booClear
 * @param STRING strTagNameInText
 * @return BOOLEAN
 */
function innerHTMLsuper(mixRepository, strText, booClear, strTagNameInText)
{
    if ((mixRepository == undefined) || (strText == undefined))
        return false;
    if (booClear == undefined)
        booClear = true;
    if (strTagNameInText != undefined)
        strTagNameInText = strTagNameInText.toUpperCase();
    if (isObject(mixRepository)) {
        var repository = mixRepository;
        var strIdRepository = repository.id;
        var strOpener = (document.getElementById(strIdRepository) == undefined) ? 'opener.' : '';
    } else {
        var strOpener = '';
        var repository = document.getElementById(mixRepository);
        if (repository == undefined) {
            strOpener = 'opener.';
            repository = opener.document.getElementById(mixRepository);
            if (repository == undefined)
                return false;
        }
        var strIdRepository = repository.id;
    }
    if (repository.tagName.toLowerCase() == 'tbody') {
        var strRepositoryBackup = replaceAll(new Array(' ', '/\n', '/\t'), '', trim(repository.innerHTML));
        var strTextBackup = replaceAll(new Array(' ', '/\n', '/\t'), '', trim(strText));
        if (strTextBackup.indexOf('<') != -1) {
            if ((strTextBackup.substring(strTextBackup.indexOf('<'), 4).toUpperCase() == '<TAB') || (strTextBackup.substring(strTextBackup.indexOf('<'), 4).toUpperCase() == '<DIV')) {
                var strFirstTd = strRepositoryBackup.substring(strRepositoryBackup.toUpperCase().indexOf('<TD'));
                var strPartRepositoryBackup = strRepositoryBackup.substring(0, (strRepositoryBackup.toUpperCase().indexOf('<TD') + strFirstTd.indexOf('>') + 1));
                strText = strPartRepositoryBackup + strText + '</td></tr>';
            }
        }
    }
    if (document.all) {
        if (booClear)
            removeChildNodes(repository);
        var strTextBackup = replaceAll(new Array(' ', '/\n', '/\t'), '', trim(strText));
        var strPartTextBackup = strTextBackup.substring(0, 3).toUpperCase();
        var booStartTd = (strPartTextBackup == '<TD');
        var booStartTr = (strPartTextBackup == '<TR');
        var booStartTbody = (strPartTextBackup == '<TBODY');
        var booStartThead = (strPartTextBackup == '<THEAD');
        if (booStartTd)
            strText = "<TABLE style='width:100%;'><TBODY><TR>" + strText + '</TR></TBODY></TABLE>';
        if (booStartTr)
            strText = "<TABLE style='width:100%;'><TBODY>" + strText + '</TBODY></TABLE>';
        if (booStartTbody)
            strText = "<TABLE style='width:100%;'>" + strText + '</TABLE>';
        if (booStartThead)
            strText = "<TABLE style='width:100%;'>" + strText + '</TABLE>';
        if ((booStartTd) || (booStartTr) || (booStartTbody) || (booStartThead))
            strTagNameInText = strPartTextBackup.substring(1).toUpperCase();
        eval("var divBackup = " + strOpener + "document.createElement('DIV');");
        divBackup.innerHTML = strText;
        var arrBackupElements = (strTagNameInText == undefined) ? divBackup.childNodes : divBackup.getElementsByTagName(strTagNameInText);
        while (arrBackupElements.length > 0)
            repository.appendChild(arrBackupElements[0]);
    } else {
        if (booClear)
            repository.innerHTML = strText;
        else
            repository.innerHTML += strText;
    }
    return true;
}

/**
 * Atrasa a execucao do script javascript em milisegundos
 *
 * @param INTEGER intMilisegundos
 * @return VOID 
 */
function sleep(intMilisegundos)
{
    if (intMilisegundos == undefined)
        intMilisegundos = 0;
    var intStart = new Date().getTime();
    for (var intCount = 0; intCount < 1e7; ++intCount) {
        if ((new Date().getTime() - intStart) > intMilisegundos)
            break;
    }
}

/**
 * Funcao que posiciona a barra de rolagem em uma ponto especificado da tela
 *
 * @param MIX mixAnchor
 * @return VOID
 */
function goToAnchor(mixAnchor)
{
    if (mixAnchor == undefined)
        return;
    window.location.href = window.location.href + '#' + mixAnchor;
}