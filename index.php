
<?php
session_start();

include "Databas/db_config.php";
include "functions/accounts.php";
include "functions/API.php";
include "functions/library.php";
include "functions/creators.php";
include "functions/categories.php";



  if($_GET["function"] == "acc"){

    $acc = new Account(new DB("localhost", "root", "", "mobilabiblan"));
    $acc->createAccount("Mogrenn", "Brandon", "Mogren", 1, 1, "hej");


  }else if($_GET["function"] == "API"){
    $API = new API(new DB("localhost", "root", "", "mobilabiblan"));
    $API->generateApiToken(1);
  }else if($_GET["function"] == "creator"){

    $creator = new Creators(new DB("localhost", "root", "", "mobilabiblan"));
    $creator->addCreator("Christopher", "Paolini");

  }else if($_GET["function"] == "lib"){

    $lib =  new Library(new DB("localhost", "root", "", "mobilabiblan"));
    $lib->addMediaBook("c++ direkt", 9789144014630, 9144014635, [1], 1, 230, "This is a book about C++ programming", [1]);

  }else if($_GET["function"] == "cat"){
    $cat = new Categories(new DB("localhost", "root", "", "mobilabiblan"));
    $cat->addCategory("Datorer & IT");
  }







 ?>
