
<?php 

require_once("Perfil.php");

function registrarse($usr,$nom,$ap,$em,$co,$gen,$fe) {

  $miembro=new Perfil($usr);
  $ex=$miembro->existe();
  if ($ex) return false;

  $miembro->setDatosPerfil($co,$nom,$ap, $em, $fe);
  if ($miembro->save()) {return true;}
  else{return false;}
}

?>
