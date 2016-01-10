$(document).ready(function () {
    $('body').on('change', '#coEstado', function() {
        feedSelect('coEstado', 'coMunicipio', '/application-municipio/' + $('#coEstado').val(), undefined, true);
    });
});