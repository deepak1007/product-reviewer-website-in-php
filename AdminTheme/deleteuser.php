<?php

session_start();
include "../config/dbconnect.php";

if(isset($_GET['user_id']))
{  try{



    $query = "delete from comments where user_id=?";
    $smt = $con->prepare($query);
    $smt->execute(array($_GET['user_id']));
    
    $query = "delete from posts where user_id=?";
    $smt = $con->prepare($query);
    $smt->execute(array($_GET['user_id']));

    $query = "delete from login where user_id=?";
    $smt = $con->prepare($query);
    $smt->execute(array($_GET['user_id']));
    $_SESSION['result'] = 1;
    $_SESSION['elaborate'] = "data deleted successfully";
header('location:index.php');


}
catch(PDOException $e)
{
    $_SESSION['result'] = 0;
    $_SESSION['elaborate'] = "sorry data could not be deleted";
    header('location:index.php');
}


}