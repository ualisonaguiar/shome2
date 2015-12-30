function removeAcao(intIdAcao)
{
    var arrParameter = new Array(),
            strUrl = '/perfil-acao/remove',
            mixResult;
    arrParameter['idPerfil'] = $('#idPerfil').val();
    arrParameter['idAcao'] = intIdAcao;
    mixResult = JSON.parse(ajaxRequest(strUrl, arrParameter));
    alertDialog(mixResult.message, 'Aviso');
    if (mixResult.status) {
        $('.fa-remove[data-acao=' + intIdAcao + ']').closest('tr').remove();
        setTimeout(function () {
            location.reload();
        }, 1000);
    }
}

function getListagemLogin()
{
    var strUrl = '/perfil-usuario/listagem-usuario',
            mixResult,
            arrParameter = new Array(),
            arrUsuario;
    arrParameter['idPerfil'] = $('#idPerfil').val();
    mixResult = JSON.parse(ajaxRequest(strUrl, arrParameter));
    $('#idLogin').empty();
    arrUsuario = mixResult.data;
    $('#idLogin').append(new Option('Selecione', ''));
    jQuery.each(arrUsuario, function (intIdLogin, strLogin) {
        $('#idLogin').append(new Option(strLogin, intIdLogin));
    });
}

$(document).ready(function () {
    $('body').on('click', '#btnVincular', function () {
        if (!$('form').valid()) {
            alertDialog('Selecione uma ação na combo', 'Aviso');
            return false;
        }
        var arrParameter = new Array(),
                strUrl = '/perfil-acao/adicionar',
                mixResult;
        arrParameter['idPerfil'] = $('#idPerfil').val();
        arrParameter['idAcao'] = $('#idAcao option:selected').val();
        mixResult = JSON.parse(ajaxRequest(strUrl, arrParameter));
        alertDialog(mixResult.message, 'Aviso');
        if (mixResult.status) {
            setTimeout(function () {
                location.reload();
            }, 1000);
        }
    }).on('click', '.fa-remove', function () {
        var intIdAcao = $(this).data('acao');
        confirmDialog('Deseja realmente excluir este vínculo?', 'Confirmação', 450, 300, 'removeAcao(' + intIdAcao + ');');
    });
});