function removeUsuario(intIdUsuario)
{
    var arrParameter = new Array(),
            strUrl = '/perfil-usuario/remove',
            mixResult;
    arrParameter['idPerfil'] = $('#idPerfil').val();
    arrParameter['idLogin'] = intIdUsuario;
    mixResult = JSON.parse(ajaxRequest(strUrl, arrParameter));
    alertDialog(mixResult.message, 'Aviso');
    if (mixResult.status) {
        $('.fa-remove[data-usuario=' + intIdUsuario + ']').closest('tr').remove();
        getListagemLogin();
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
            alertDialog('Selecione usuário na combo', 'Aviso');
            return false;
        }
        var arrParameter = new Array(),
                strUrl = '/perfil-usuario/adicionar',
                mixResult;
        arrParameter['idPerfil'] = $('#idPerfil').val();
        arrParameter['idLogin'] = $('#idLogin option:selected').val();
        mixResult = JSON.parse(ajaxRequest(strUrl, arrParameter));
        alertDialog(mixResult.message, 'Aviso');
        if (mixResult.status) {
            $('#usuarioVinculado').removeClass('hide');
            var strTableLine = '<tr>';
            strTableLine += '<td>' + mixResult.data.noPessoaFisica + '</td>';
            strTableLine += '<td>' + mixResult.data.noLogin + '</td>';
            strTableLine += '<td>' + mixResult.data.inSituacao + '</td>';
            strTableLine += '<td><i class="fa fa-remove" data-usuario="' + mixResult.data.idLogin + '" title="Remover Usuário" style="cursor: pointer"></i></td></tr>';
            $('#usuarioVinculado tbody').append(strTableLine);
            $('#idLogin option:selected').remove();
        }
    }).on('click', '.fa-remove', function () {
        var intIdLogin = $(this).data('usuario');
        confirmDialog('Deseja realmente excluir este vínculo?', 'Confirmação', 450, 300, 'removeUsuario(' + intIdLogin + ');');
    });
});