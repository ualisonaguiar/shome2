function buscaEndereco(intCoCep)
{
    exp = /\d{2}\.\d{3}\-\d{3}/
    if (!exp.test(intCoCep)) {
        alertDialog('CEP inválido.', 'Validação', 200, 150);
        return false;
    }
    intCoCep = intCoCep.replace(/\D/g, "");
    intCoCep = intCoCep.replace(/^(\d{5})(\d{9})/, "$1-$2");
    var arrParametro = new Array();
    arrParametro['cep'] = intCoCep;
    openWaitDialog();
    var resultConsulta = JSON.parse(ajaxRequest('/ajax-dne/buscarEnderecoCep', arrParametro,null, null, null, null, null, null, null, null, true));
    closeWaitDialog();
    if (!resultConsulta.status) {
        alertDialog('Sistema do CEP está indsiponível no momento. Erro: ' + resultConsulta.message, 'Validação', 300, 250);
        return false;
    }
    return JSON.parse(resultConsulta.data);
}

$(document).ready(function () {
    $('.data-single').datepicker($.datepicker.regional[ "pt-br" ]);
    $('.data-single').mask('00/00/0000');
    $('.cep-single').mask('00.000-000');
    $('.mask-cpf').mask('999.999.999-99');
    $('.mask-cnpj').mask('99.999.999/9999-99');

//    $('.mask-money').priceFormat({
//        prefix: 'R$ ',
//        centsSeparator: ',',
//        thousandsSeparator: '.',
////        clearPrefix: true
//    });
});