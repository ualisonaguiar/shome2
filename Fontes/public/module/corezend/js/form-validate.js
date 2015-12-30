function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58))
        return true;
    else {
        if (tecla == 8 || tecla == 0)
            return true;
        else
            return false;
    }
}

$(document).ready(function () {
    // validate the comment form when it is submitted
    $(".form-validate").validate();
    // validate signup form on keyup and submit
    $(".form-validate").validate({
        rules: {
            required: true
        }       
    });
    $.validator.messages.required = "Campo obrigatório.";
    
//    $('body').on('click', ".form-validate button[type='submit']", function(event) {
//        event.preventDefault();
//        if (!$("form").valid()) {
//            $('label.erro-form-validate').removeClass('erro-form-validate');
//            $('input[aria-required="true"], select[aria-required="true"]').each(function () {
//                if ($(this).val() == '') {
//                    $(this).parent().children('label').addClass('erro-form-validate');
//                }
//            });
//            if ($('label.erro-form-validate').length) {
//                alertDialog('Favor preencher os campos obrigatórios.', 'Validação', 350, 250);
//                return false;            
//            }
//        } else {
//            $("form").submit();
//        }
//    });
});