<?php

class Account{

    private $DB;

    function __construct($DB){
      $this->DB = $DB;
    }

    function __destruct(){
      $this->DB->closeConnection();
    }

    //This generates a random 20 digit private key
    protected function generateKey(){
      $values = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $key = "";

      for($i = 0; $i < 20; $i++){
        $key .= $values[rand(0,strlen($values)-1)];
      }
      return $key;
    }

    //Generates a random 10 digit alphanumeric password
    protected function generatePassword(){
      $values = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $password = "";

      for($i = 0; $i < 10; $i++){
        $password .= $values[rand(0,strlen($values)-1)];
      }
      return $password;
    }

    //hashes with blowfish $2a$10$
    protected function hashPassword($password){
      $Blowfish_Pre = '$2a$10$';
      $Blowfish_End = '$';

      $values = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $Chars_Len = 62;

      $Salt_Length = 21;
      $salt = "";

      for ($i = 0; $i < $Salt_Length; $i++) {
        $salt .= $values[rand(0, $Chars_Len-1)];
      }

      $bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
      $hashed_password = crypt($password, $bcrypt_salt);

      return [0=>$hashed_password, 1=>$salt];
    }

    public function createAccount($username, $fName, $sName, $libraryID, $role, $password = ""){
      $key = $this->generateKey();
      $returnPass = false;

      //if password was not given generate one
      if($password == "" || $password == null){
        $password = $this->generatePassword();
        $returnPass = true;
      }

      //hash password and send it do the database
      $hashedPassword = $this->hashPassword($password);
      $sql = "INSERT INTO users(username, password, salt, firstName, surName, privateKey) VALUES('$username', '$hashedPassword[0]', '$hashedPassword[1]', '$fName', '$sName', '$key')";
      $this->DB->query($sql);
      $userID = $this->DB->getInsertedID();
      $sql = "INSERT INTO libraryConnection(userID, libraryID) VALUES($userID, $libraryID)";
      $this->DB->query($sql);
      $sql = "INSERT INTO accountroles(userID, roleID) VALUES($userID, $role)";
      $this->DB->query($sql);

      //in case of generated password show it to the user
      if($returnPass){
        echo $password;
      }
    }

    //Deletes the account with associated ID
    public function deleteAccount($userID){
      $sql = "DELETE FROM users WHERE id=$userID";
      $this->$DB->query($sql);
    }

    public function editAccount($sql){

    }
}
