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
    $("#usrnameTBox").focus();
    $("#usrnameTBox").after('<span id="usrSt" class="usrSt"></span>');
    $("#emailTBox").after('<span id="emailSt" class="emailSt"></span>');
    $("#email2TBox").after('<span id="email2St" class="email2St"></span>');
    $("#passwd2TBox").after('<span id="passwd2St" class="passwd2St"></span>');

    /**
     * Informa al usuario si el las contraseñas coinciden
     */
    //$("#passwd2TBox").keyup(function(){testCoincidencia("passwd")});

    $("#passwd2TBox").keyup(function(){
        if($(this).val() != $("#passwdTBox").val()) {
            $(".passwd2St").attr('style', '')
                .attr('style', "color:red;")
                .html('No coinciden');
        } else {
            $(".passwd2St").attr('style', '')
                .attr('style', "color:green;")
                .html('Coinciden!!!');
            $(".passwd2St").fadeOut(2500);
        }
    });

    
    /**
     * Informa al usuario si el los correos electrónicos coinciden
     */
//    $("#email2TBox").keyup(function(){testCoincidencia('email')});

    $("#email2TBox").keyup(function(){
        if($(this).val() != $("#emailTBox").val()) {
            $(".email2St").attr('style', '')
                .attr('style', "color:red;")
                .html('No coinciden');
        } else {
            $(".email2St").attr('style', '')
                .attr('style', "color:green;")
                .html('Coinciden!!!');
            $(".email2St").fadeOut(2500);
        }
    });
                

    /**
     * Informa al usuario si el username introducido está disponible
     */
    $("#usrnameTBox").keyup(function(){
        if ($(this).val().length > 2) {
        $.ajax({
            type: 'POST',
            url: 'ajax/ajaxPerfil.php',
            data: { function : "askForUsr", usrname: $(this).val() },
            dataType: 'html',
            success: function(data) {
                var response = $.parseJSON(data);
                if(response.exists) {
                    $(".usrSt").attr('style', '')
                        .attr('style', "color:red;")
                        .html('YA ESTÁ EN USO');
                } else {
                    $(".usrSt").attr('style', '')
                        .attr('style', "color:green;")
                        .html('Disponible!!!');
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
    $("#usrnameTBox").focusout(function(){
        if ($(this).val().length != 0 &&
            $("#usrSt").html() == 'Disponible!!!'
           ) {
            $(".usrSt").fadeOut(2500);
        }
    });

    /**
     * Informa al usuario si el email introducido está disponible
     */
    $("#emailTBox").keyup(function(){
        if ($(this).val().length > 2) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxPerfil.php',
                data: { function : "askForEmail", email: $(this).val() },
                dataType: 'html',
                success: function(data) {
                    var response = $.parseJSON(data);
                    if(response.exists) {
                        $(".emailSt").attr('style', '')
                            .attr('style', "color:red;")
                            .html('YA ESTÁ EN USO');
                    } else {
                        $(".emailSt").attr('style', '')
                            .attr('style', "color:green;")
                            .html('Disponible!!!');
                        //$(".emailSt").fadeOut(2500);
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
    $("#emailTBox").focusout(function(){
        if ($(this).val().length != 0 &&
            $("#emailSt").html() == 'Disponible!!!'
           ) {
            $(".emailSt").fadeOut(2500);
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