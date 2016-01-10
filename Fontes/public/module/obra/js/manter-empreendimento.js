$(document).ready(function () {
    $('body').on('change', '#coCep', function() {
        var mixResult = buscaEnderecoCep($(this).val());
        if (mixResult !== false) {
            $('#coEstado').val(mixResult.idEstado);
            feedSelect('coEstado', 'coMunicipio', '/application-municipio/' + $('#coEstado').val(), mixResult.idMunicipio, true);
            $('#dsLogradouro').val(mixResult.logradouro);
            $('#dsBairro').val(mixResult.bairro);
        }
    });
});