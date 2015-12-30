/**
 * Remove tudo que nao seja inteiro de uma string
 *
 * @param STRING strText
 * @param BOOLEAN booLeftZero
 * @example alert(forceInt("1a2b3c4"))
 */
function forceInt(strText, booLeftZero)
{
    strText += '';
    booLeftZero = (booLeftZero == undefined) ? false : booLeftZero;
    var strNumbers = '1234567890\n';
    var strNewText = '';
    for (var intCount = 0; intCount < strText.length; ++intCount) {
        if (strNumbers.indexOf(strText.charAt(intCount)) != -1)
            strNewText += strText.charAt(intCount);
    }
    if (strNewText == '')
        return '';
    if (!booLeftZero)
        strNewText = parseInt(strNewText, 10);
    return strNewText;
}

/**
 * Remove tudo que nao seja ponto flutuante de uma string
 *
 * @param STRING strText
 * @param STRING strDot
 * @param FLOAT
 * @example alert(forceDouble("1a2b3c4.5aX"))
 */
function forceDouble(strText, strDot)
{
    strText = strText.replace(strDot, '.');
    var strNumbers = '1234567890.\n';
    var strNewText = '';
    for (var intCount = 0; intCount < strText.length; ++intCount) {
        if (strNumbers.indexOf(strText.charAt(intCount)) != -1)
            strNewText += strText.charAt(intCount);
    }
    if (strNewText == '')
        return '';
    var floNew = parseFloat(strNewText, 10);
    strNewText = floNew + '';
    strText = strText.replace('.', strDot);
    return strText;
}

/**
 * Remove todos os numeros de uma string
 *
 * @param STRING strValue
 * @return STRING
 */
function removeAllNumber(strValue)
{
    if (strValue == undefined)
        return;
    var intCount = 0;
    while (intCount <= 10) {
        eval("strValue = replaceAll(strValue, '" + intCount + "', '');");
        ++intCount;
    }
    return strValue;
}