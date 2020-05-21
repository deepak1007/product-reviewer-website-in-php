<?php
session_start();
include "../config/dbconnect.php";

if(isset($_GET['user_id']))
{


     try{
        $query = "select password, email, user_id from login where user_id=?";
        $smt = $con->prepare($query);
        $smt->execute(array($_GET['user_id']));
    
        $row = $smt->fetch();
        
        echo json_encode(array("status"=>200, "data"=>$row));
     }
     catch(PDOException $e)
     { 
         echo json_encode(array("status"=>201, "data"=>$e->getMessage()));
     }
  

        
}
else
{
    echo json_encode(array("status"=>201, "data"=>"no"));
}