<?php

if(isset($_COOKIE['login_username']))
{
       $_SESSION['login'] = 1;
       try{
           $query = "select profile_picture from login where user_id=?";
           $smt = $con->prepare($query);
           $smt->execute(array($_COOKIE['login_username']));
           
           $row = $smt->fetch();

           if($row['profile_picture']=='')
           {
               $_SESSION['propic'] = 'images/question.jpg';
               
           }
           else
           {
               $_SESSSION['propic'] = $row['profile_picture'];
           }
           

       }
       catch(PDOException $e)
       {
          echo "alert(". $e->getMessage().")";
       }
       $_SESSION['user_id'] = $_COOKIE['login_username'];
       
       
}
?>