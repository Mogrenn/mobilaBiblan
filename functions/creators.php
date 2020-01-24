<?php

class Creators{

  private $DB;

  function __construct($DB){
    $this->DB = $DB;
  }

  function __destruct(){
    $this->DB->closeConnection();
  }

  public function addCreator($firstName, $surName){
    $sql = $this->DB->prepare("INSERT INTO creators(firstName, surName) VALUES(?,?)");
    $sql->bind_param("ss", $firstName, $surName);
    $sql->execute();
    $sql->close();
  }

  public function removeCreator($creatorID){
    
  }

  public function editCreator(){

  }

  public function getCreators(){

  }

}
