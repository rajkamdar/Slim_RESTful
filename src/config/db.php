<?php

  class db{

    private $dbhost='localhost';
    private $dbuser='root';
    private $dbpass="";
    private $dbname='slimapp';

    function connect(){
      $mysql_connect_str="mysql:host=$this->dbhost;dbname=$this->dbname;";
      $dbconnection=new PDO($mysql_connect_str,$this->dbuser,$this->dbpass);

      $dbconnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

      return $dbconnection;
    }

  }

 ?>
