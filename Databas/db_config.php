<?php

class DB{

  protected static $host;
  protected static $user;
  protected static $password;
  protected static $database;
  protected $conn;

  function __construct($host,$user,$password,$database){
    self::$host = $host;
    self::$user = $user;
    self::$password = $password;
    self::$database = $database;
    $this->conn = mysqli_connect(DB::$host, DB::$user, DB::$password, DB::$database);
  }

  public function query($sql){
    $this->conn->query($sql);
  }

  public function prepare($stmt){
    return $this->conn->prepare($stmt);
  }

  public function getData($sql){
    return $this->conn->query($sql);
  }

  public function getInsertedID(){
    return $this->conn->insert_id;
  }

  public function closeConnection(){
    $this->conn->close();
  }

}
