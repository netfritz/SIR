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

function testCoincidencia(selector){
    if($("#"+selector+"2TBox").val() != $("#"+selector+"TBox").val()) {
        $("."+selector+"2St").attr('style', '')
            .attr('style', "color:red;")
            .html('No coinciden');
    } else {
        $("."+selector+"2St").attr('style', '')
            .attr('style', "color:green;")
            .html('Coinciden!!!');
        $("."+selector+"2St").fadeOut(2500);
    }
}

$(document).ready(function(){
    $(".error").hide();
    $("#usrnameTBox").focus();
    $("#usrnameTBox").after('<span id="usrSt" class="usrSt"></span>');
    $("#emailTBox").after('<span id="emailSt" class="emailSt"></span>');
    $("#email2TBox").after('<span id="email2St" class="email2St"></span>');
    $("#passwd2TBox").after('<span id="passwd2St" class="passwd2St"></span>');

    /**
     * Informa al usuario si el las contraseñas coinciden
     */
    $("#passwd2TBox").keyup(testCoincidencia("passwd"));
/*
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
*/
    
    /**
     * Informa al usuario si el las contraseñas coinciden
     */
    $("#email2TBox").keyup(testCoincidencia("email"));
/*
    $("#email2TBox").keyup(function(){
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
 */               

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
    
});