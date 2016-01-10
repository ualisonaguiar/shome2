function buscaEnderecoCep(strCep)
{
    openWaitDialog();
    var arrParameter = new Array();
    arrParameter['co_cep'] = strCep;
    var mixResult = JSON.parse(ajaxRequest('/application-cep', arrParameter));
    closeWaitDialog();
    if (!mixResult.status) {
        alertDialog(mixResult.message);
        return false;
    }
    return mixResult.data;
}