/**
 * Concatena todos os itens de um array ligando-os por um string
 *
 * @param STRING strGlue
 * @param ARRAY arrPieces
 * @return STRING
 */
function implode(strGlue, arrPieces)
{
    if (arrPieces == undefined)
        return 'undefined';
    var strResult = '';
    for (var intCount = 0; intCount < arrPieces.length; ++intCount) {
        if (strResult != '')
            strResult += strGlue;
        strResult += arrPieces[intCount];
    }
    return strResult;
}

/**
 * Quebra uma expressao (com uma string de separacao) em array
 *
 * @param STRING strSeparator
 * @param STRING strText
 * @return ARRAY
 */
function explode(strSeparator, strText)
{
    strText += '';
    strSeparator += '';
    var intCount = 0;
    var intCountMax = strText.length;
    var arrResult = new Array();
    var intSeparatorPos = strText.indexOf(strSeparator);
    var boolInsert = true;
    while ((intSeparatorPos != -1) && (intCount < intCountMax)) {
        if (intSeparatorPos == 0) {
            var strBefore = strText.substr(0, 1);
            var strAfter = strText.substr(1);
            boolInsert = false;
        } else {
            var strBefore = strText.substr(0, intSeparatorPos);
            var strAfter = strText.substr(intSeparatorPos + 1);
        }
        if ((strBefore != undefined) && (strBefore != null))
            arrResult.push(strBefore);
        strText = strAfter;
        var intSeparatorPos = strText.indexOf(strSeparator);
        ++intCount;
    }
    if (boolInsert)
        arrResult.push(strText);
    return arrResult;
}

/**
 * Funcao que realiza um cast array, ou seja, converte um objeto em array
 *
 * @param OBJECT object
 * @param BOOLEAN booOriginalKey
 * @return ARRAY
 */
function parseArray(object, booOriginalKey)
{
    if (booOriginalKey == undefined)
        booOriginalKey = false;
    var arrNew = new Array();
    if (object.length) {
        for (var intCount = 0; intCount < object.length; ++intCount)
            arrNew[intCount] = object[intCount];
    } else {
        for (var strAttribute in object) {
            if (!isFunction(object[strAttribute]))
                arrNew[(booOriginalKey) ? strAttribute : arrNew.length] = object[strAttribute];
        }
    }
    return arrNew;
}

/**
 * Funcao que realiza um cast array, ou seja, converte um objeto em array
 *
 * @param MIX mixElement
 * @param INTEGER intDepthOfRecursive
 * @return ARRAY
 */
function parseArrayRecursive(mixElement, intDepthOfRecursive)
{
    if (intDepthOfRecursive == undefined)
        intDepthOfRecursive = -1;
    if (intDepthOfRecursive > 0)
        --intDepthOfRecursive;
    else {
        if (intDepthOfRecursive == 0)
            return mixElement;
        if (intDepthOfRecursive < 0)
            return null;
    }
    var arrNew = new Array();
    if (mixElement == undefined) {
        // mixElemento vazio
    } else if (isString(mixElement) || isNumber(mixElement) || isBoolean(mixElement))
        arrNew[arrNew.length] = mixElement;
    else if (mixElement.length) {
        for (var intCount = 0; intCount < mixElement.length; ++intCount)
            arrNew[intCount] = parseArrayRecursive(mixElement[intCount], intDepthOfRecursive);
    }
    else if (mixElement.innerHTML)
        arrNew = mixElement.innerHTML;
    else if (isObject(mixElement)) {
        for (var strAttribute in mixElement) {
            if (!isFunction(mixElement[strAttribute]))
                arrNew[arrNew.length] = parseArrayRecursive(mixElement[strAttribute], intDepthOfRecursive);
        }
    } else
        arrNew = null;
    return arrNew;
}

/**
 * Procura por um elemento no array e retorna sua posicao caso seja 
 * encontrado, ou -1 caso nao encontre
 *
 * @param MIX mixElement
 * @param ARRAY arrContainer
 * @param INTEGER intNumElementsArray
 * @param INTEGER
 */
function array_search(mixElement, arrContainer, intNumElementsArray)
{
    if (!arrContainer)
        return -1;
    for (var intCount = 0; intCount < arrContainer.length; ++intCount) {
        if (intNumElementsArray == undefined) {
            if (arrContainer[intCount] == mixElement)
                return intCount;
        } else {
            var mixNumElementsArrayParam = new Array();
            if ((isArray(mixElement)) && (isArray(arrContainer[intCount]))) {
                mixNumElementsArrayParam = intNumElementsArray;
                if (mixElement.length < intNumElementsArray)
                    mixNumElementsArrayParam = mixElement.length;
                if (arrContainer[intCount].length < intNumElementsArray)
                    mixNumElementsArrayParam = arrContainer[intCount].length;
            }
            var boolEqual = true;
            for (var intCount2 = 0; intCount2 < mixNumElementsArrayParam; ++intCount2) {
                if (mixElement[intCount2] != arrContainer[intCount][intCount2]) {
                    boolEqual = false;
                    break;
                }
            }
            if (boolEqual)
                return intCount;
        }
    }
    return -1;
}

/**
 * Insere um valor no array caso nao exista no mesmo
 *
 * @param ARRAY arrElements
 * @param MIX mixValue
 * @return ARRAY
 */
function insertDistinctValueIntoArray(arrElements, mixValue)
{
    if ((arrElements == undefined) || (mixValue == undefined))
        return false;
    if (array_search(mixValue, arrElements) == -1)
        arrElements[arrElements.length] = mixValue;
    return arrElements;
}