<?php

class Admin{

  private $DB;

  function __construct($DB){
    $this->DB = $DB;
  }

  function __destruct(){
    $this->DB->closeConnection();
  }

  
}
