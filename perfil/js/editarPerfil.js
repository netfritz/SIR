/*
 * Desplaza la página al siguiente tag de interés.
 * target: tag o id, o cualquier selector con sintaxis de jquery al cual se
 *         desea desplazar.
 * focused: tag que será enfocado después de desplazar la página. por lo general
 *          algo de tipo input. Recibe un selector con sintaxis de jquery.
 */
function desplazar(target,focused){
    //conseguir el tope del desface del tag destino
    var target_offset = $(target).offset();
    var target_top = target_offset.top;
    //ir al tag deslizando hasta el tope del mismo
    $('html, body').animate({scrollTop:target_top}, 500, function(){
        if (focused != null) {
            $(focused).focus();
        }
    });
}

// Mide la fortaleza de una contraseña usando expresiones regulares
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

/*
 * Se encarga de desplegar y contraer un panel.
 */
function alternar(container, num, focus,desplegados,paneles) {
    if (num < 0 || 5 < num){
        alert("Ha ocurrido un error al tratar de desplegar o contraer el contenedor ("+container+"), con el número ("+num+")");
    }
    var panelSelector = '#'+container;
    var panelAnchor = "#"+container+"Anc";
    var buttonSelector = "#colapse"+container;
    //alert('panelSelector: ('+panelSelector+')\npanelAnchor: ('+panelAnchor+')\nbuttonSelector: ('+buttonSelector+')\ndesplegados['+num+']: '+desplegados[num]);
    desplegados[num] = !desplegados[num];
    $(panelSelector).slideToggle(50);
    if (desplegados[num]) {
        $(buttonSelector).html('\\/');
        //desplazar(panelAnchor,focus);
    } else {
        $(buttonSelector).html('\>');
        //desplazar(panelAnchor,null);
    }
}
$(document).ready(function(){

    // ACCIONES AL RENDERIZAR LA PÁGINA:
    // Variables para el monitoreo del estado de los páneles
    var desplegados = new Array(6);
    desplegados[0] = true;
    desplegados[1] = true;
    desplegados[2] = true;
    desplegados[3] = true;
    desplegados[4] = true;
    desplegados[5] = true;
    var paneles = new Array(6);
    paneles[0] = "Photo";
    paneles[1] = "Basic";
    paneles[2] = "Contact";
    paneles[3] = "Academic";
    paneles[4] = "Misc";
    paneles[5] = "Security";

    //Creo los espacios para mostrar los errores:
    $("#usrname").focus();
    $("#ajaxUsr").html('<td colspan=\"4\"><span id="usrSt" class="usrSt"></span></td>');
    $("#ajaxEmail").html('<span id="emailSt" class="emailSt"></span>');
    $("#ajaxEmail2").html('<span id="email2St" class="email2St"></span>');
    $("#ajaxEmailAlt").html('<span id="emailAltSt" class="emailAltSt"></span>');
    $("#ajaxEmailAlt2").html('<span id="emailAlt2St" class="emailAlt2St"></span>');
    $("#ajaxPasswd").html('<td colspan=\"4\"><span id="passwdSt" class="passwdSt"></span></td>')
        .after('<tr id="ajaxPasswd2" class="error"><td colspan=\"4\"><span id="passwd2St" class="passwd2St"></span></td></tr>');
    $(".submitButton").attr('onsubmit','');

    $(".error").hide();

    // contraer todos los paneles al momento de cargar la página
    alternar("Photo",0,"foto",desplegados,paneles);
    alternar("Basic",1,"nombre",desplegados,paneles);
    alternar("Contact",2,"email",desplegados,paneles);
    alternar("Academic",3,"carnet",desplegados,paneles);
    alternar("Misc",4,"actividadesExtra",desplegados,paneles);
    alternar("Security",5,"",desplegados,paneles);

    /*
     * Monitores para contraer/desplegar los paneles, tanto todos al mismo
     * tiempo, como cada uno individualmente
     */
    $(".showAllFlip").click(function(){
        for (i = 0; i < 6; i++) {
            if (!desplegados[i]) {
                alternar(paneles[i],i,"",desplegados,paneles);
            }
        }
        return false;
    });
    $(".hideAllFlip").click(function(){
        for (i = 0; i < 6; i++) {
            if (desplegados[i]) {
                alternar(paneles[i],i,"",desplegados,paneles);
            }
        }
        return false;
    });
    $(".FotoFlip").click(function(){
        alternar("Photo",0,"foto",desplegados,paneles);
        return false;
    });
    $(".BasicFlip").click(function(){
        alternar("Basic",1,"nombre",desplegados,paneles);
        return false;
    });
    $(".ContactFlip").click(function(){
        alternar("Contact",2,"email",desplegados,paneles);
        return false;
    });
    $(".AcadFlip").click(function(){
        alternar("Academic",3,"carnet",desplegados,paneles);
        return false;
    });
    $(".MiscFlip").click(function(){
        alternar("Misc",4,"actividadesExtra",desplegados,paneles);
        return false;
    });
    $(".SecurityFlip").click(function(){
        alternar("Security",5,"",desplegados,paneles);
        return false;
    });


    // CHEKEOS AL ESCRIBIR (ON THE FLY)
    // Variables para las pruebas de validez
    var usrDisp = false;
    var emailDisp = false;
    var emailCoinciden = false;
    var emailAltCoinciden = false;
    var passwdCoinciden = false;

    // Valido la fortaleza de la contraseña
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

    // Valido que las contraseñas coincidan
    $("#passwd2").keyup(function(){
        $("#ajaxPasswd2").show();
        var coinciden = $(this).val() == $("#passwd").val();
        var verde = passwdStrong && coinciden;
        if (verde) {
            $(".passwd2St").attr('style', '')
                .attr('style','color:green;');
        } else {
            $(".passwd2St").attr('style', '')
                .attr('style','color:red;');
        }
        passwdCoinciden = coinciden;
        if (coinciden) {
            $(".passwd2St").html('<p style=\"text-align: center;\">Las contraseñas coinciden!</p>');
            $("#ajaxPasswd2").fadeOut(3000);
        } else {
            $(".passwd2St").html('<p style=\"text-align: center;\">Las contraseñas no coinciden!</p>');
        }
    });

    // Valido que los correos coincidan
    $("#email2").keyup(function(){
        $("#ajaxEmailRow").show();
        $("#ajaxEmail").show();
        $("#ajaxEmail2").show();
        var coinciden = $(this).val() == $("#email").val();
        emailCoinciden = coinciden;
        if (coinciden) {
            $(".email2St").attr('style', '')
                .attr('style','color:green;')
                .html('<p style=\"text-align: center;\">Los correos electrónicos coinciden!</p>');
            $("#ajaxEmail2").fadeOut(3000);
        } else {
            $(".email2St").attr('style', '')
                .attr('style','color:red;')
                .html('<p style=\"text-align: center;\">Los correos electrónicos no coinciden!</p>');
        }
    });

    // Valido que los correos alternativos coincidan
    $("#emailAlt2").keyup(function(){
        $("#ajaxEmailAltRow").show();
        $("#ajaxEmailAlt").show();
        $("#ajaxEmailAlt2").show();
        var coinciden = $(this).val() == $("#emailAlt").val();
        emailCoinciden = coinciden;
        if (coinciden) {
            $(".emailAlt2St").attr('style', '')
                .attr('style','color:green;')
                .html('<p style=\"text-align: center;\">Los correos electrónicos alternativos coinciden!</p>');
            $("#ajaxEmailAlt2").fadeOut(3000);
        } else {
            $(".emailAlt2St").attr('style', '')
                .attr('style','color:red;')
                .html('<p style=\"text-align: center;\">Los correos electrónicos alternativos no coinciden!</p>');
        }
    });

    

    // VALIDACIONES AL ENVIAR EL FORMULARIO:
    $(".submitBtn").click(function() {
        $('.error').hide();

        // Verifico la fortaleza del password
        if (passwordStrongness($("#passwd").val()) < 3) {
            alert('La contraseña que introdujo no es suficientemente fuerte!\nAl menos debe ser medianamente fuerte...');
            if (!desplegados[1]) {
                alternar("Basic",1,"nombre",desplegados,paneles);
            }
            $("#passwd").focus();
            $("#ajaxPasswd").show();
            $(".passwdSt").attr('style','')
                .attr('style', "color:red;")
                .html('<p style=\"text-align: center;\">Contraseña muy debil...</p>');
            return false;
        }

        // Verifico que las contraseñas coincidan
        if ($("#passwd2").val() != $("#passwd").val()) {
            alert('Las contraseñas no coinciden!');
            if (!desplegados[1]) {
                alternar("Basic",1,"nombre",desplegados,paneles);
            }
            $("#passwd2").focus();
            $(".passwd2St").attr('style', '')
                .attr('style','color:red;');
            $(".passwd2St").html('<p style=\"text-align: center;\">Las contraseñas no coinciden!</p>');
            return false;
        }

        // Verifico que haya alguna opcion marcada para el sexo:
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

        // Verifico que los correos coincidan
        if ($("#email2").val() != $("#email").val()) {
            alert('Los correos electrónicos no coinciden!');
            if (!desplegados[1]) {
                alternar("Contact",2,"email2",desplegados,paneles);
            }
            $("#email2").focus();
            $("#ajaxEmailRow").show();
            $("#ajaxEmail").show();
            $("#ajaxEmail2").show();
            $(".email2St").attr('style', '')
                .attr('style','color:red;');
            $(".email2St").html('<p style=\"text-align: center;\">Los correos electrónicos no coinciden!</p>');
            return false;
        }

        // Verifico que los correos alternativos coincidan
        if ($("#emailAlt2").val() != $("#emailAlt").val()) {
            alert('Los correos electrónicos alternativos no coinciden!');
            if (!desplegados[1]) {
                alternar("Contact",2,"emailAlt2",desplegados,paneles);
            }
            $("#emailAlt2").focus();
            $("#ajaxEmailAltRow").show();
            $("#ajaxEmailAlt").show();
            $("#ajaxEmailAlt2").show();
            $(".emailAlt2St").attr('style', '')
                .attr('style','color:red;');
            $(".emailAlt2St").html('<p style=\"text-align: center;\">Los correos electrónicos alternativos no coinciden!</p>');
            return false;
        }
    });
});