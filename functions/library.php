<?php

class Library{

  private $DB;

  function __construct($DB){
    $this->DB = $DB;
  }

  function __destruct(){
    $this->DB->closeConnection();
  }

  //insert a book into the system
  //$creators is an array and categories is also an array
  public function addMediaBook($title, $barcode, $isbn, $categories, $libraryID, $pageCount, $desc, $creators = []){

    //check if isbn alread exists
    $sql = $this->DB->prepare("SELECT *FROM isbn where isbnNumber=?");
    $sql->bind_param("i", $isbn);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    $isbnID;

    //insert isbn to table with title and authors
    if(mysqli_num_rows($result) <= 0){
      $sql = $this->DB->prepare("INSERT INTO isbn(title, isbnNumber) VALUES(?,?)");
      $sql->bind_param("si", $title, $isbn);
      $sql->execute();
      $isbnID = $this->DB->getInsertedID();

      //connect the authors of the book to the isbnNumber
      for($i = 0; $i < count($creators); $i++){
        $sql = $this->DB->prepare("INSERT INTO mediacreators(creatorID, isbnID) VALUES(?,?)");
        $sql->bind_param("ii", $creators[$i], $isbnID);
        $sql->execute();
        $sql->close();
      }

      $sql->close();
    }else{
      $sql = $this->DB->prepare("SELECT ID FROM isbn WHERE isbnNumber = ?");
      $sql->bind_param("i", $isbn);
      $sql->execute();
      $result = $sql->get_result();

      $row = $result->fetch_assoc();
      $isbnID = $row["ID"];
    }

    //insert into media with libraryID and the barcode
    $sql = $this->DB->prepare("INSERT INTO media(libraryID, barcode) VALUES(?,?)");
    $sql->bind_param("ii", $libraryID, $barcode);
    $sql->execute();
    $mediaID = $this->DB->getInsertedID();
    $sql->close();

    //insert into isbn and media middle table to connect them with eachother
    $sql = $this->DB->prepare("INSERT INTO mediaisbn(isbnID, mediaID) VALUES(?,?)");
    $sql->bind_param("ii", $isbnID, $mediaID);
    $sql->execute();
    $sql->close();

    //insert into book with pageCount and the description
    $sql = $this->DB->prepare("INSERT INTO book(mediaID, pageCount, description) VALUES(?,?,?)");
    $sql->bind_param("iis", $mediaID, $pageCount, $desc);
    $sql->execute();
    $sql->close();

    //connect the books categories to the book
    for($i = 0; $i < count($categories); $i++){
      $sql = $this->DB->prepare("INSERT INTO mediacategories(categoryID, mediaID) VALUES(?,?)");
      $sql->bind_param("ii", $categories[$i], $mediaID);
      $sql->execute();
      $sql->close();
    }
  }

  public function removeMedia($mediaID){
    $sql = $this->DB->prepare("DELETE FROM media where ID=?");
    $sql->bind_param("s", $mediaID);
    $sql->execute();
  }

  public function editMedia(){

  }

  public function getMedia($mediaType){

  }

}
