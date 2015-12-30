$(document).ready(function() {
    $('#formPessoaFisica').validate();
    
    $('body').on('change', '#dsEmail, #dsCpf', function() {
        if ($(this).val()) {
            var arrParameter = new Array();
            arrParameter[$(this).attr('id')] = $(this).val();
            var booValidate = JSON.parse(ajaxRequest('/pessoa/ajaxCheckInformation', arrParameter));
            if (booValidate.status) {
                $(this).val('');
                if ($(this).attr('id') == 'dsEmail') {
                    alertDialog('E-mail já cadatrado', 'Validação', 300, 150);
                }
                if ($(this).attr('id') == 'dsCpf') {
                    alertDialog('CPF já cadatrado', 'Validação', 300, 150);
                }                
            }
        }
    });
});