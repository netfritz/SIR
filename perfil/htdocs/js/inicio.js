/**
 * Desplaza la página al siguiente tag de interés.
 * target: tag o id, o cualquier selector con sintaxis de jquery al cual se
 *         desea desplazar.
 * focused: tag que será enfocado después de desplazar la página. por lo general
 *          algo de tipo input. Recibe un selector con sintaxis de jquery.
 */
function desplazar(target,focused){
    //conseguir el tope d3el desface del tag destino
    var target_offset = $(target).offset();
    var target_top = target_offset.top;
    //ir al tag deslizando hasta el tope del mismo
    $('html, body').animate({scrollTop:target_top}, 500, function(){
        $(focused).focus();
    });
}

$(document).ready(function(){
/******************************************************************************/
/**********************   CHEQUEOS DURANTE LA ESCRITURA    ********************/
/******************************************************************************/
    $(".error").hide();
    $("#usrname").focus();
    $("#ajaxUsr").html('<td colspan=\"2\"><span id="usrSt" class="usrSt"></span></td>');
    $("#ajaxEmail").html('<td colspan=\"2\"><span id="emailSt" class="emailSt"></span></td>');
    $("#ajaxEmail2").html('<td colspan=\"2\"><span id="email2St" class="email2St"></span></td>');
    $("#ajaxPasswd2").html('<td colspan=\"2\"><span id="passwd2St" class="passwd2St"></span></td>');

    var usrDisp = false;
    var emailDisp = false;
    var emailCoinciden = false;
    var passwdCoinciden = false;

    /**
     * Informa al usuario si el las contraseñas coinciden
     */
    //$("#passwd2TBox").keyup(function(){testCoincidencia("passwd")});

    $("#passwd2").keyup(function(){
        if($(this).val() != $("#passwd").val()) {
            $("#ajaxPasswd2").show();
            $(".passwd2St").attr('style', '')
                .attr('style', "color:red;")
                .html('<p style=\"text-align: center;\">No coinciden</p>');
        } else {
            $("#ajaxPasswd2").show();
            $(".passwd2St").attr('style', '')
                .attr('style', "color:green;")
                .html('<p style=\"text-align: center;\">Coinciden!!!</p>');
            $("#ajaxPasswd2").fadeOut(2500);
        }
    });


    /**
     * Informa al usuario si el los correos electrónicos coinciden
     */
//    $("#email2TBox").keyup(function(){testCoincidencia('email')});

    $("#email2").keyup(function(){
        if($(this).val() != $("#email").val()) {
            $("#ajaxEmail2").show();
            $(".email2St").attr('style', '')
                .attr('style', "color:red;")
                .html('<p style=\"text-align: center;\">No coinciden</p>');
        } else {
            $("#ajaxEmail2").show();
            $(".email2St").attr('style', '')
                .attr('style', "color:green;")
                .html('<p style=\"text-align: center;\">Coinciden!!!</p>');
            $("#ajaxEmail2").fadeOut(2500);
        }
    });


    /**
     * Informa al usuario si el username introducido está disponible
     */
    $("#usrname").keyup(function(){
        if ($(this).val().length > 2) {
        $.ajax({
            type: 'POST',
            url: 'ajax/ajaxPerfil.php',
            data: { function : "askForUsr", usrname: $(this).val() },
            dataType: 'html',
            success: function(data) {
                var response = $.parseJSON(data);
                if(response.exists) {
                    $("#ajaxUsr").show();
                    $(".usrSt").attr('style', '')
                        .attr('style', "color:red;")
                        .html('<p style=\"text-align: center;\">YA ESTÁ EN USO</p>');
                    usrDisp = false;
                } else {
                    $("#ajaxUsr").show();
                    $(".usrSt").attr('style', '')
                        .attr('style', "color:green;")
                        .html('<p style=\"text-align: center;\">Disponible!!!</p>');
                    usrDisp = true;
                    //$(".usrSt").fadeOut(2500);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert("Error!!! =/");
            }
        });
        } else {
            $(".usrSt").attr('style', '')
                .attr('style', "display:none;")
                .html('');
        }
    });
    $("#usrname").focusout(function(){
        if ($(this).val().length != 0 && usrDisp ) {
            $("#ajaxUsr").fadeOut(2500);
        }
    });

    /**
     * Informa al usuario si el email introducido está disponible
     */
    $("#email").keyup(function(){
        if ($(this).val().length > 2) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxPerfil.php',
                data: { function : "askForEmail", email: $(this).val() },
                dataType: 'html',
                success: function(data) {
                    var response = $.parseJSON(data);
                    if(response.exists) {
                        $("#ajaxEmail").show();
                        $(".emailSt").attr('style', '')
                            .attr('style', "color:red;")
                            .html('<p style=\"text-align: center;\">YA ESTÁ EN USO</p>');
                        emailDisp = false;
                    } else {
                        $("#ajaxEmail").show();
                        $(".emailSt").attr('style', '')
                            .attr('style', "color:green;")
                            .html('<p style=\"text-align: center;\">Disponible!!!</p>');
                        //$(".emailSt").fadeOut(2500);
                        emailDisp = true;
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert("Error!!! =/");
                }
            });
        } else {
            $(".emailSt").attr('style', '')
                .attr('style', "display:none;")
                .html('');
        }
    });
    $("#email").focusout(function(){
        if ($(this).val().length != 0 && emailDisp) {
            $("#ajaxEmail").fadeOut(2500);
        }
    });


/******************************************************************************/
/**********************     VALIDACIONES DEL FORMULARIO    ********************/
/******************************************************************************/

    $(".button").click(function() {
        $('.error').hide();
        // validar y procesar de aqui en adelante:
        var name = $("input#name").val();
        if (name == "") {
            $("label#name_error").show();
            $("input#name").focus();
            return false;
        }
        var email = $("input#email").val();
        if (email == "") {
            $("label#email_error").show();
            $("input#email").focus();
            return false;
        }
        var phone = $("input#phone").val();
        if (phone == "") {
            $("label#phone_error").show();
            $("input#phone").focus();
            return false;
        }

    });

});