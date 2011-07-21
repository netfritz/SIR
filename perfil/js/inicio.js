/*
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

function passwordStrongness(string) {
    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    if (string.length==0) {
        return 0;
    } else if (false == enoughRegex.test(string)) {
        return 1;
    } else if (strongRegex.test(string)) {
        return 4;
    } else if (mediumRegex.test(string)) {
        return 3;
    } else {
        return 2;
    }
}

$(document).ready(function(){
/******************************************************************************/
/**********************   CHEQUEOS DURANTE LA ESCRITURA    ********************/
/******************************************************************************/
    $(".error").hide();

    //Creo los espacios para mostrar los errores:
    $("#usrname").focus();
    $("#ajaxUsr").html('<td colspan=\"2\"><span id="usrSt" class="usrSt"></span></td>');
    $("#ajaxEmail").html('<td colspan=\"2\"><span id="emailSt" class="emailSt"></span></td>');
    $("#ajaxEmail2").html('<td colspan=\"2\"><span id="email2St" class="email2St"></span></td>');
    $("#ajaxPasswd").html('<td colspan=\"2\"><span id="passwdSt" class="passwdSt"></span></td>');
    $("#ajaxPasswd2").html('<td colspan=\"2\"><span id="passwd2St" class="passwd2St"></span></td>');
    $(".submitButton").attr('onsubmit','');

    //Validaciones de tamaño de campo:
    $("#usrname").attr('maxlength','20');
    $("#passwd").attr('maxlength','40');
    $("#email").attr('maxlength','100');
    $("#nombre").attr('maxlength','30');
    $("#apellido").attr('maxlength','30');

    // Variables para el chekeo on the fly
    var usrDisp = false;
    var emailDisp = false;
    var emailCoinciden = false;
    var passwdCoinciden = false;
    var passwdStrong = false;

    /*
     * Informa al usuario si el las contraseñas coinciden
     */
    $("#passwd2").keyup(function(){
        if($(this).val() != $("#passwd").val()) {
            $("#ajaxPasswd2").show();
            $(".passwd2St").attr('style', '')
                .attr('style', "color:red;")
                .html('<p style=\"text-align: center;\">Las contraseñas no coinciden</p>');
        } else {
            $("#ajaxPasswd2").show();
            $(".passwd2St").attr('style', '')
                .attr('style', "color:green;")
                .html('<p style=\"text-align: center;\">Las contraseñas coinciden!!!</p>');
            $("#ajaxPasswd2").fadeOut(2500);
        }
    });


    /*
     * Informa al usuario si el los correos electrónicos coinciden
     */
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


    /*
     * Informa al usuario si el username introducido está disponible y es válido
     */
    $("#usrname").keyup(function(){
        var hola;
        if ($(this).val().length > 2) {
            hola = $.ajax({
            type: 'POST',
            url: '/rspinf-usb/perfil/src/controladores/ajaxPerfilController.php',
            data: { function : "askForUsr", usrname: $(this).val() },
            dataType: 'html',
            success: function(data) {
                var response = $.parseJSON(data);
                maxchar = false;
                if ($("#usrname").val().length > 20) {
                    tamconst = '<li><p style=\"text-align: center;\">El nombre de usuario debe tener máximo 20 caracteres!</p></li>';
                    maxchar = true;
                } else {
                    tamconst = '';
                    maxchar = false;
                }
                if(response.exists) {
                    $("#ajaxUsr").show();
                    $(".usrSt").attr('style', '')
                        .html('<ul style=\"list-style-type: none;text-align: center;\">'+tamconst+'<li><p style=\"text-align: center;\">Este nombre de usuario ya está en uso.</p></li></ul>');
                    usrDisp = false;
                } else {
                    $("#ajaxUsr").show();
                    $(".usrSt").attr('style', '')
                        .html('<ul style=\"list-style-type: none;text-align: center;\">'+tamconst+'<li><p style=\"text-align: center;\">Nombre de usuario disponible!!!</p></li></ul>');
                    usrDisp = true;
                }
                if (maxchar || !usrDisp) {
                    $(".usrSt").attr('style', 'color:red;');
                } else {
                    $(".usrSt").attr('style', 'color:green;');
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
        return hola;
    });
    $("#usrname").focusout(function(){
        if ($(this).val().length != 0 && usrDisp ) {
            $("#ajaxUsr").fadeOut(2500);
        }
    });

    /*
     * Informa al usuario si el email introducido está disponible y es válido
     */
    $("#email").keyup(function(){
        if ($(this).val().length > 4) {
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-\.])+)+\.([a-zA-Z0-9]{2,4})+$/;
            var valid = false;
            if (!filter.test($(this).val())) {
                $("#ajaxEmail").show();
                $(".emailSt").attr('style', '')
                    .attr('style', "color:red;")
                    .html('<p style=\"text-align: center;\">Correo inválido. Por favor introduzca un correo válido (i.e.: username@pinf.com)</p>');
                emailDisp = false;
                valid = false;
            } else {
                valid = true;
                emailDisp = true;
                $.ajax({
                    type: 'POST',
                    url: '/rspinf-usb/perfil/src/controladores/ajaxPerfilController.php',
                    data: { function : "askForEmail", email: $(this).val() },
                    dataType: 'html',
                    success: function(data) {
                        var response = $.parseJSON(data);
                        if(response.exists) {
                            $("#ajaxEmail").show();
                            $(".emailSt").attr('style', '')
                                .attr('style', "color:red;")
                                .html('<p style=\"text-align: center;\">Este correo electrónico ya está en uso</p>');
                            emailDisp = false;
                        } else {
                            $("#ajaxEmail").show();
                            $(".emailSt").attr('style', '')
                                .attr('style', "color:green;")
                                .html('<p style=\"text-align: center;\">Correo electrónico disponible!!!</p>');
                            emailDisp = true;
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        alert("Error!!! =/");
                    }
                });
            }
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

    /*
     * Valida la fortaleza de la contraseña
     */
    $("#passwd").keyup(function(){
        contrasena = $(this).val();
        fortaleza = passwordStrongness(contrasena);
        $("#ajaxPasswd").show();
        $(".passwdSt").attr('style', '');
        if (fortaleza == 0) {
            passwdStrong = false;
            $(".passwdSt").html('<p style=\"text-align: center;\">Por favor introduzca una contraseña...</p>');
        } else if (fortaleza == 1) {
            passwdStrong = false;
            $(".passwdSt").html('<p style=\"text-align: center;\">Por favor introduzca más caracteres...</p>');
        } else if (fortaleza == 2) {
            passwdStrong = false;
            $(".passwdSt").attr('style', "color:red;")
                .html('<p style=\"text-align: center;\">Contraseña muy debil...</p>');
        } else if (fortaleza == 3) {
            passwdStrong = true;
            $(".passwdSt").attr('style', "color:orange;")
                .html('<p style=\"text-align: center;\">Contraseña medianamente fuerte...</p>');
        } else if (fortaleza == 4) {
            passwdStrong = true;
            $(".passwdSt").attr('style', "color:green;")
                .html('<p style=\"text-align: center;\">Contraseña fuerte!!!</p>');
            $("#ajaxPasswd").fadeOut(3000);
        }
    });
    $("#passwd").focusout(function(){
        if ($(this).val().length != 0 && passwdStrong) {
            $("#ajaxPasswd").fadeOut(3000);
        }
    });

/******************************************************************************/
/**********************     VALIDACIONES DEL FORMULARIO    ********************/
/******************************************************************************/

    $(".submitButton").click(function() {
        $('.error').hide();
        // validar y procesar de aqui en adelante:
        var usrnameval = $("input#usrname").val();
        if (usrnameval == '') {
            $("label#usrname_error").show();
            $("input#usrname").focus();
            alert('El nombre de usuario es un campo obligatorio!');
            return false;
        }

        if (usrnameval.length > 20) {
            $("input#usrname").focus();
            alert('El nombre de usuario puede contener máximo 20 caracteres!');
            return false;
        }

        var name = $("input#nombre").val();
        if (name == '') {
            $("label#nombre_error").show();
            $("input#nombre").focus();
            alert('El nombre es un campo obligatorio!');
            return false;
        }

        var lname = $("input#apellido").val();
        if (lname == '') {
            $("label#apellido_error").show();
            $("input#apellido").focus();
            alert('El apellido es un campo obligatorio!');
            return false;
        }
        var emailval = $("input#email").val();
        if (emailval == '') {
            $("label#email_error").show();
            $("input#email").focus();
            alert('El email es un campo obligatorio!');
            return false;
        }

        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-\.])+)+\.([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test($("input#email").val())) {
            alert('Por favor, introduzca un e-mail válido!');
            $("input#email").focus();
            return false;
        }

        var email2 = $("input#email2").val();
        if (email2 == '') {
            $("label#email2_error").show();
            $("input#email2").focus();
            alert('Confirmar el email es obligatorio!');
            return false;
        }

        var passwd = $("input#passwd").val();
        if (passwd == '') {
            $("label#passwd_error").show();
            $("input#passwd").focus();
            alert('La contraseña es un campo obligatorio!');
            return false;
        }
        var passwd2 = $("input#passwd2").val();
        if (passwd2 == '') {
            $("label#passwd2_error").show();
            $("input#passwd2").focus();
            alert('Confirmar la contraseña es obligatorio!');
            return false;
        }

        sex = $(".radiosexo");
        bool = false;
        for(i=0; ele = sex[i];i++)
            if(ele.checked)
                bool = true;
        if (!bool) {
            sex[0].focus();
            alert('El sexo es un campo obligatorio!');
            return false;
        }

        if (emailval != email2) {
            $("input#email2").focus();
            alert('Los correos no coinciden!');
            return false;
        }

        if (passwd != passwd2) {
            $("input#passwd2").focus();
            alert('Las contraseñas no coinciden!');
            return false;
        }

        if (!usrDisp) {
            $("input#usrname").focus();
            alert('Este nombre de usuario no está disponible!');
            return false;
        }

        if (!emailDisp) {
            $("input#email").focus();
            alert('Este correo no está disponible!');
            return false;
        }

        if (!passwdStrong) {
            $("input#passwd").focus();
            alert('Esta contraseña no es suficientemente fuerte!\nAl menos debe ser medianamente fuerte...');
            return false;
        }
    });

});