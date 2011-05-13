Sistemas Integrales Roraima
=============================
SUGU - Sistema Universal de Gestión Universitaria
-------------------------------------------------

Instruccions para configurar la base de datos:

Para realizar el deploy es necesario configurar primero las credenciales de
acceso a la base de datos. Actualmente esto lo configuramos en el archivo
'class/model/DataBase.php'. Allí se debe cambiar el valor de los atributos
$usr y $passwd para que sean correctos. Lo más sencillo es que se coloque de
$usr a "root" y en $passwd la clave de root de su base de datos MySQL.
Si no tiene clave, basta colocar el string ""
No modifique los atributos $db y $host

Después de esto corra el script 'database/SIR.sql' para que se cargue el esquema
de la base de datos.

