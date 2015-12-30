$(document).ready(function () {
    function pesquisar() {
        openWaitDialog();
        $('.listagem').removeClass('hide');
        var strUrl = '/pessoa/ajaxListagem',
            arrParameter = new Array(),
            strHtmlListagem = '';
        $('#formSearchPessoaFisica input:text').each(function () {
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
    }).on('click', '.fa-edit', function() {
        location.href= strGlobalBasePath + '/pessoa/edit/' + $(this).data('pessoa');
    }).on('click', '.fa-mail-forward', function () {
        openWaitDialog();
        var strUrl = '/pessoa/ajaxReenvioSenha',
            arrParameter = new Array(),
            result;
        arrParameter['idPessoaFisica'] = $(this).data('pessoa');
        result = JSON.parse(ajaxRequest(strUrl, arrParameter));
        closeWaitDialog();
        alertDialog(result.message, 'Aviso', 350, 150);
    }).on('click', '.fa-list-alt', function() {
        location.href= strGlobalBasePath + '/pessoa/historico-reenvio/' + $(this).data('pessoa');
    });
});