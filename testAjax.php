<?php
  require_once("dbConnect.php");
  include("test.php");

        $db = new dbConnect();
      if(isset($_POST['jsonString'])){
        $res = $_POST['jsonString']; 
        echo $res;
       
        }else{
          echo "session capture unsuccessful";
      }
?>