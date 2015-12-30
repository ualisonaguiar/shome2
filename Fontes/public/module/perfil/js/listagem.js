$(document).ready(function () {
    function pesquisar() {
        openWaitDialog();
        $('.listagem').removeClass('hide');
        var strUrl = '/perfil/ajaxListagem',
                arrParameter = new Array(),
                strHtmlListagem = '';
        $('#formSearchPerfil input:text, #formSearchPerfil select').each(function () {
            arrParameter[$(this).attr('id')] = $(this).val();
        });
        strHtmlListagem = ajaxRequest(strUrl, arrParameter);
        $('#tableListagem tbody').html(strHtmlListagem);
        closeWaitDialog();
        if (!strHtmlListagem) {
            $('#tableListagem tbody').html('<td colspan=5><strong>Não foi encontrado resultado com filtro informado.</strong></td>');
        }
    }
    $('body').on('click', '#btnPesquisar', function () {
        pesquisar();
    }).on('click', '#tableListagem .fa-edit', function () {
        location.href = strGlobalBasePath + '/perfil/edit/' + $(this).data('perfil');
    }).on('click', '#tableListagem .alterar-situacao', function () {
        var arrParameter = new Array(),
            strUrl = '/perfil/ajax-alterar-situacao',
            mixResult;
        arrParameter['idPerfil'] = $(this).data('perfil');
        mixResult = JSON.parse(ajaxRequest(strUrl, arrParameter));
        alertDialog(mixResult.message, 'Aviso');
        if (mixResult.status) {
            $('#btnPesquisar').trigger('click');
        }
    }).on('click', '#tableListagem .fa-users', function() {
        location.href = strGlobalBasePath + '/perfil-usuario/index/' + $(this).data('perfil');
    }).on('click', '#tableListagem .fa-tasks', function() {
        location.href = strGlobalBasePath + '/perfil-acao/index/' + $(this).data('perfil');
    });
});