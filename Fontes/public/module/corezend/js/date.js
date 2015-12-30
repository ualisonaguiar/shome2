/**
 * Converte uma string data (DD/MM/YYYY ou YYYY-MM-DD) em objeto data
 *
 * @param STRING strDate
 * @return DATE
 */
function strToDate(strDate)
{
    if (strDate.indexOf('/') != -1) {
        var arrDate = explode('/', strDate);
        return new Date(arrDate[2], arrDate[1] - 1, arrDate[0]);
    } else if (strDate.indexOf('-') != -1) {
        var arrDate = explode('-', strDate);
        return new Date(arrDate[0], arrDate[1] - 1, arrDate[2]);
    }
    return null;
}

/**
 * Retorna a diferenca que existe entre duas datas no formato DD/MM/YYYY ou YYYY-MM-DD, em dias
 *
 * @param STRING strDate1
 * @param STRING strDate2
 * @return INTEGER
 */
function dateDiff(strDate1, strDate2)
{
    if ((strDate1 == undefined) || (strDate2 == undefined))
        return false;
    var date1 = strToDate(strDate1);
    var date2 = strToDate(strDate2);
    var intDiff = (date2.getTime() > date1.getTime()) ? (date2.getTime() - date1.getTime()) : (date1.getTime() - date2.getTime());
    return Math.floor(intDiff / (60 * 60 * 24 * 1000));
}

/**
 * Verifica se a data incial eh maior que a data final, 
 * dentro de elementos inputs
 *
 * @param MIX mixDataInicial 
 * @param MIX mixDataFinal
 * @return BOOL 
 */
function compareDates(mixDataInicial, mixDataFinal)
{
    var dataInicial = getObject(mixDataInicial);
    var dataFinal = getObject(mixDataFinal);
    if ((dataInicial == undefined) || (dataFinal == undefined))
        return false;
    return compareDatesValues(dataInicial.value, dataFinal.value);
}

/**
 * Verifica se a data incial eh maior que a data final
 *
 * @param STRING strDataInicial 
 * @param STRING strDataFinal
 * @return BOOL 
 */
function compareDatesValues(strDataInicial, strDataFinal)
{
    if ((strDataInicial == undefined) || (strDataFinal == undefined))
        return false;
    if ((strDataInicial.length < 10) || (strDataFinal.length < 10))
        return false;
    var strCaracFormato = strDataInicial.substr(2, 1);
    var booDiaMesAno = ((strCaracFormato == '-') || (strCaracFormato == '_') || (strCaracFormato == '/') || (strCaracFormato == '|') || (strCaracFormato == '\\'));
    strDataInicial = replaceAll(strDataInicial, new Array('-', '_', '/', '|', '\\\\', ' '), '');
    strDataFinal = replaceAll(strDataFinal, new Array('-', '_', '/', '|', '\\\\', ' '), '');
    var intDataInicial = (booDiaMesAno) ? strDataInicial.substr(4, 4) + '' + strDataInicial.substr(2, 2) + '' + strDataInicial.substr(0, 2) : strDataInicial;
    var intDataFinal = (booDiaMesAno) ? strDataFinal.substr(4, 4) + '' + strDataFinal.substr(2, 2) + '' + strDataFinal.substr(0, 2) : strDataFinal;
    if ((strDataInicial.length > 8) && (strDataFinal.length > 8)) {
        var intMaxSubstr = (strDataInicial.length > strDataFinal.length) ? strDataFinal.length : strDataInicial.length;
        intDataInicial += '' + strDataInicial.substr(8, intMaxSubstr);
        intDataFinal += '' + strDataFinal.substr(8, intMaxSubstr);
    }
    if (intDataInicial > intDataFinal) {
        alertDialog('A data inicial deve ser sempre menor ou igual a data final.', 'Validação', 200, 150);
        return false;
    }
    return true;
}