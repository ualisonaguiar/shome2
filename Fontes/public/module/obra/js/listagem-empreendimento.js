$(document).ready(function () {
    function pesquisar() {
        openWaitDialog();
        $('.listagem').removeClass('hide');
        var strUrl = '/empreendimento-obra/ajaxListagem',
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
    }).on('click', '.alterar-situacao', function() {
        openWaitDialog();
        var arrParameter = new Array(),
            mixResult;
        arrParameter['idEmpreendimento'] = $(this).data('empreendimento');
        mixResult = JSON.parse(ajaxRequest('/empreendimento-obra/alterar-situacao', arrParameter));
        closeWaitDialog();
        alertDialog(mixResult.message);
        if (!mixResult.status) {
            return false;
        }
        pesquisar();
    });
});