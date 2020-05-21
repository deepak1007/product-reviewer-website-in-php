<?php

session_start();
include "../config/dbconnect.php";

if(isset($_GET['post_id']))
{  try{



    
    
    $query = "delete from posts where post_id=?";
    $smt = $con->prepare($query);
    $smt->execute(array($_GET['post_id']));

    
    $_SESSION['result'] = 1;
    $_SESSION['elaborate'] = "data deleted successfully";
header('location:manposts.php');


}
catch(PDOException $e)
{
    $_SESSION['result'] = 0;
    $_SESSION['elaborate'] = "sorry data could not be deleted";
    header('location:manposts.php');
}


}