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
    });
});