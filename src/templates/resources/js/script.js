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

var desplegado = false; // Indica si el formulario de dpto está desplegado o no

$(document).ready(function(){
    document.forms.solicitud.username.focus();
    /*
      $("#tabla_solUsr tr:first").append('<span id="usrSt" class="usrSt"></span>');
      $("tr:nth-child(4)").append('<span id="emailSt" class="emailSt"></span>');
    
      Gracias a la respuesta a mi pregunta en stackoverflow:
      http://stackoverflow.com/questions/5698364/selecting-non-unique-tags-with-jquery-without-a-name-or-id
    */
    $("label[for='id_username']").parent().parent().append('<span id="usrSt" class="usrSt"></span>');
    $("label[for='id_email']").parent().parent().append('<span id="emailSt" class="emailSt"></span>');
    
    /**
     * Informa al usuario si el username introducido está disponible
     */
    $("#id_username").keyup(function(){
        if ($(this).val().length > 2) {
        $.ajax({
            type: 'POST',
            url: '/registro/usr/solicitud/ajax/askForUsrName/',
            data: { usrname: $(this).val() },
            dataType: 'text',
            success: function(data) {
                if(data) {
                    $(".usrSt").attr('style', '')
                        .attr('style', "color:red;")
                        .html('YA ESTÁ EN USO');
                } else {
                    $(".usrSt").attr('style', '')
                        .attr('style', "color:green;")
                        .html('Disponible!!!');
                }
            },
            /*
              beforeSend: function(){
              $email.addClass('show_loading_in_right')
              },
              //
              complete: function() {
              $(".usrSt").fadeOut(2500);
              }*/           
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
    $("#id_email").keyup(function(){
        if ($(this).val().length > 2) {
        $.ajax({
            type: 'POST',
            url: '/registro/usr/solicitud/ajax/askForEmail/',
            data: { correo : $(this).val() },
            dataType: 'text',
            success: function(data) {
                if(data) {
                    $(".emailSt").attr('style', '')
                        .attr('style', "color:red;")
                        .html('YA ESTÁ EN USO');
                } else {
                    $(".emailSt").attr('style', '')
                        .attr('style', "color:green;")
                        .html('Disponible!!!');
                }
            },
            /*
              beforeSend: function(){
              $email.addClass('show_loading_in_right')
              },
              //
              complete: function() {
              $(".usrSt").fadeOut(2500);
              }*/
            
        });
        } else {
            $(".emailSt").attr('style', '')
                .attr('style', "display:none;")
                .html('');
        }
    });

    /**
     * Se encarga de desplegar y contraer el formulario de departamento.
     */
    $(".flip").click(function(){
        desplegado = !desplegado;
        $(".panel").slideToggle("slow");
        if (desplegado) {
            desplazar("#dptoAnch","#id_codigo");            
        } else {
            desplazar("#id_username","#id_username");
        }
    });


    /**
     * Registra el departamento en la base de datos, y añade la nueva 
     * opción a la lista desplegable.
     */
    $("#btnRegDpto").click(function(){
        // Primero hay que validar los campos (TODO)
        var cod;
        var nom;
        var mail;
        var dir;
        var tlf;
        var valid = true;

        // Si los campos son válidos, enviar al servidor.
        if (valid) {
            var cod = $(".panel #id_codigo").val();
            var nom = $(".panel #dptoForm #id_nombre").val();
            var mail = $(".panel #id_correo").val();
            var dir = $(".panel #id_direccion").val();
            var tlf = $(".panel #id_telefono").val();

            var datos = { codigo : cod, nombre : nom, correo : mail, direccion : dir, telefono : tlf };

            // Luego, mando lo recaudado al servidor
            $.ajax({
                data : datos,
                datatype : 'json', 
                type : 'POST', 
                url : "/registro/dpto/solicitud/ajax/", 
                success : function(result){
                    if (result.error) {
                        alert(result.error);
                        $("#dptoForm table").after('<div id="dptoErrors"></div>');
                        $("#dptoErrors").html("<table></table>");
                        for (var i = 0; i < result.errors.length; i++) {
                            $("#dptoErrors table").append("<tr><p>"+result.errors[i]+"</p></tr>")
                        }
                    } else {
                        $("#id_dpto").append('<option value="'+result["pk"]+'">'+result["nombre"]+'</option>');
                        desplegado = !desplegado;
                        $(".panel").slideToggle("slow");
                        desplazar("#id_dpto","#id_dpto");
                    }
                },
                error : function(error){
                    alert("Ha ocurrido un error!!!:\n" + error);
                }
            });
        }
    });
});