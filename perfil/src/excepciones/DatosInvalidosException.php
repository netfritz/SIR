<?php
class DatosInvalidosException extends Exception {
  private $msg;
  public function __construct(){
    if (func_num_args()==0) {
    } else if (func_num_args()==1) {
      $args = func_get_args();
      $this->msg = $args[0];
    }
  }

  public function getMsg(){
    return $this->msg;
  }
}
?>