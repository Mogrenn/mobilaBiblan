<?php


class API{

  private $DB;

  function __construct($DB){
    $this->DB = $DB;
  }

  function __destruct(){
    $this->DB->closeConnection();
  }

  public function generateApiToken($userID){
    $sql = "SELECT privateKey FROM users where ID=$userID";
    $result = $this->DB->getData($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $privateKey = $row["privateKey"];
    $values = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $key = "";

    for($i = 0; $i < 20; $i++){
      $key .= $values[rand(0,strlen($values)-1)];
    }
    $cipher = "AES-128-CBC";
    $ivLen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivLen);
    $cryptedKey = openssl_encrypt($key, "AES-128-CBC", $privateKey, $options=0, $iv);
    $sql = "INSERT INTO API(publicKey, expiryDate, userID) VALUES('$cryptedKey', DATE_ADD(NOW(), INTERVAL 2 HOUR), $userID)";
    $this->DB->query($sql);
    echo $cryptedKey;
  }



}
