<?php

class Categories{

  private $DB;

  function __construct($DB){
    $this->DB = $DB;
  }

  function __destruct(){
    $this->DB->closeConnection();
  }

  public function addCategory($category){
    $sql = $this->DB->prepare("INSERT INTO categories(name) VALUES(?)");
    $sql->bind_param("s", $category);
    $sql->execute();
    $sql->close();
  }

  public function removeCategory($categoryID){
    $sql = $this->DB->prepare("DELETE FROM categories WHERE ID =?");
    $sql->bind_param("i", $categoryID);
    $sql->execute();
    $sql->close();
  }

  public function editCategory(){

  }

  public function getCategories(){

  }


}
