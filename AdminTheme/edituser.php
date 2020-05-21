<?php 

session_start();
include "../config/dbconnect.php";

if(isset($_GET['user_id']))
{
      //  $username = $_POST['username'];
        $password =md5( $_POST['password']);
        $email = $_POST['email'];

     try{


        $query = "update login set password= '$password', email='$email' where user_id=?";
        $smt = $con->prepare($query);
        $smt->execute(array($_GET['user_id']));
    
        $_SESSION['result'] = 1;
        $_SESSION['elaborate'] = "Data is saved successfully";
        header('location:index.php');
        //echo json_encode(array("status"=>200, "data"=>"Data is saved"));
     }
     catch(PDOException $e)
     {  $_SESSION['result'] = 0;
        $_SESSION['elaborate'] = "error occured";
       
    header('location:index.php');
        // echo json_encode(array("status"=>201, "data"=>$e->getMessage()));
     }
  

        
}
else
{  
    $_SESSION['result'] = 0;
    $_SESSION['elaborate'] = "Data wasn't changed";
header('location:index.php');
    //echo json_encode(array("status"=>201, "data"=>"Data wasn't changed"));
}