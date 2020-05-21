<?php 
session_start();
include_once "../config/dbconnect.php" ;

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action']=='setusercredentials')
{      $err = array("email"=>'', "full name"=>'' , 'password'=>'' , 'confirm'=>'' ,'userid'=>'');

      if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['userid']) && isset($_POST['password']))
      {
          $fullname =htmlspecialchars($_POST['firstname'] .' '. $_POST['lastname']);
        if (!preg_match("/^[a-zA-Z ]*$/",$fullname)) {
            $err['full name'] = "*Only letters and white space allowed";
          }


          $userid = htmlspecialchars($_POST['userid']);
          if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{7,15}$/', $userid) )
          {
              $err['userid'] = "*can containonly numbers and letters must be 8 to 15 characters";
          }
         else{
            $smt= $con->prepare("select count(*) from login where user_id=?");
            $smt->execute(array($_POST['userid']));
            $result = $smt->fetch()['count(*)'];
            if($result)
            {
                $err['userid'] = "*username already exists";
  
            }
  
         }
        

          $email = htmlspecialchars($_POST['email']);
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err['email'] = "*Invalid email format";
          }


          $password = htmlspecialchars($_POST['password']);
          if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,15}$/', $password)) {
            $err['password'] =  '*the password does not meet the requirements!
            there has to be at least one number
            and at least one letter 
            and it has to be a number, a letter or one of the following: !@#$% 
            and there have to be 8-12 characters';
        }

        if($password != $_POST['passwordcf'])
        {
            $err['confirm'] = "*password doesn't match";
        }
           

          $activation = 1;
          $activation_code = md5($email.time());
           $date_of_joining = time(); 
             $user_public_id = uniqid(random_int(10000,99999));
       

          if($err["email"]!=''|| $err["full name"]!='' || $err['password']!='' || $err['confirm']!='' || $err['userid']!='')
          {
               echo json_encode(array("status" => 202 , "data"=>$err));
               die();
          }   

          $password = md5($password);
      try{
        $query = "insert into login values(0,:fullname, :userid,:user_public_id, :email, :passd,'', '', '','$date_of_joining',0,0,'','', 0)";

        $smt = $con->prepare($query);
        $smt->bindParam('fullname', $fullname);
        $smt->bindParam('userid', $userid);
        $smt->bindParam('email', $email);
        $smt->bindParam('passd', $password);
        $smt->bindParam('user_public_id',$user_public_id);

        if($smt->execute())
        {  /* $to=$email;
            $msg= "Thanks for new Registration.";
            $subject="Email verification (phpgurukul.com)";
            $headers .= "MIME-Version: 1.0"."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
            $headers .= 'From:dkboss12333@gmail.com'."\r\n";
            $ms.="<html></body><div><div>Dear $name,</div></br></br>";
            $ms.="<div style='padding-top:8px;'>Please click The following link For verifying and activation of your account</div>
            <div style='padding-top:10px;'><a href='http://www.phpgurukul.com/demos/emailverify/email_verification.php?code=$activationcode'>Click Here</a></div>
            <div style='padding-top:4px;'>Powered by <a href='phpgurukul.com'>phpgurukul.com</a></div></div>
            </body></html>";
            mail($to,$subject,$ms,$headers);
            echo "<script>alert('Registration successful, please verify in the registered Email-Id');</script>";
            echo "<script>window.location = 'login.php';</script>";;*/
            $_SESSION['login'] = 1;
            $_SESSION['user_id']=$userid;
            $_SESSION['propic'] = 'images/question.jpg';
            setcookie('login_username', $userid, time() + 3600, '/', NULL);
            echo json_encode(array('status'=>200, "data"=>"registration successfull"));

            
            
        }
      }
      catch(PDOException $e)
      {
           echo json_encode(array('status'=>201, "data"=>$e->getMessage()));
      }
      
      }
      else
      {
        
      }


}

else if($_SERVER['REQUEST_METHOD']== 'POST' && $_GET['action']=="getlogincredentials")
{
    if(isset($_POST['useremail']) && isset($_POST['loginpassword']))
    {
        $username= htmlspecialchars($_POST['useremail']);
        $password= md5(htmlspecialchars($_POST['loginpassword']));
    try{
        $query = "select * from login where user_id=? and password=?";
        $smt = $con->prepare($query);
     $smt->execute(array($username, $password));

        $smt->setFetchMode(PDO::FETCH_ASSOC);
           $count = 0 ;
           $type = '';
        while($row = $smt->fetch())
        {  
             $type = $row['type'];
            $count = $count + 1;
        }
        if($count> 0)
        {   
            if($row['profile_picture']=='')
            {
                $_SESSION['propic'] = 'images/question.jpg';
              
                
            }
            else
            {
                $_SESSSION['propic'] = $row['profile_picture'];

            }
           if($type == 0){
            $_SESSION['login'] = 1;
            $_SESSION['user_id']= $username;
            setcookie('login_username', $username , time() + 3600, '/', NULL);
            echo json_encode(array("code"=>200, "data"=>"successfull" , "type"=> $type));
            die();}
            else
            {
                $_SESSION['login'] = 1;
                $_SESSION['admin']= $username;
                setcookie('login_username', $username , time() + 3600, '/', NULL);
                echo json_encode(array("code"=>200, "data"=>"successfull" , "type"=> $type));
                die();
            }
        }
       else
       {
           echo json_encode(array("status"=>200, "data"=>"unsuccessfull"));
       }
    }
     catch(PDOException $e)
     {
         echo $e->getMessage();
     }

        
    }
    else
    {
        echo "";
    }
}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action']=='changes')
{   $err = array("email"=>'', "full name"=>'' , 'state'=>'' , 'address'=>'' ,'userid'=>'');
    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['address']) && isset($_POST['state']))
    {
           $fullname= $_POST['firstname'] . " " . $_POST['lastname'];
           if (!preg_match("/^[a-zA-Z ]*$/",$fullname)) {
            $err['full name'] = "*Only letters and white space allowed";
          }



           $address =htmlspecialchars($_POST['address']);
          /* if (!preg_match("'/^[A-Za-z ][A-Za-z0-9 ]{0,100}$/'",$address)) {
            $err['address'] = "*Only letters and white space allowed";
          }*/


           $state = $_POST['state'];
           if (!preg_match("/^[a-zA-Z ]*$/",$state)) {
            $err['state'] = "*Only letters and white space allowed";
          }
          
          if( $err["full name"]!='' || $err['address']!=''|| $err['state']!='')
          {
               echo json_encode(array("status" => 202 , "data"=>$err));
               die();
          }   

try{


           $query = "update login set user_name = ?, address= ?, state=? where user_id=?";
           $smt = $con->prepare($query);
           $result = $smt->execute(array($fullname, $address, $state, $_SESSION['user_id']));
           if($result == 1)
           {
               echo json_encode(array("status"=>200, "data"=>'changes saved'));
               
           }
           else
           {
               echo json_encode(array("status"=>201, "data"=>"changes not saved"));
           }

    }
    catch(PDOException $e)
    {
        echo json_encode(array("status"=>201, "data"=>$e->getMessage()));

    }
}
}
else if($_SERVER['REQUEST_METHOD'] && $_GET['action'] == 'profilepicupload')
{


    if(isset($_FILES['profile_picture']) && isset($_SESSION['user_id']))
    {
        $filename = $_FILES['profile_picture']['name'];
        $filesize = $_FILES['profile_picture']['size'];
        $filetmp =  $_FILES['profile_picture']['tmp_name'];
        $filetype = $_FILES['profile_picture']['type'];
        $fileext = explode("/", $filetype)[1];
        $errors = array();
        



  if(in_array($fileext,array('jpeg','png', 'jpg'))==FALSE)
      {
          $error[] = "sorry type is not valid, make sure your are uploading png or jpeg/jpg pictures";
      }
      if($filesize > 6000000)
      {
          $error[] = "sorry file size exceeds maximum";
      }
      if(empty($error))
      {
          move_uploaded_file($filetmp, '../profile_pictures/'. $filename);
          $filelocation = "profile_pictures/". $filename;
          try{
            $query = "update login set profile_picture=? where user_id=?";
            $smt = $con->prepare($query);
            $result=$smt->execute(array($filelocation, $_SESSION['user_id']));
            echo json_encode(array("status"=>200, "data"=>$filelocation));
          }
          catch(PDOException $e)
          {
              echo json_encode(array("status"=>200, "data"=>$e->getMessage()));
          }
        
          
          
          
      }
      else
      {
          $response= "sorry there were cirtain problem in uploading<br> ";
          for($i=0 ; $i< count($error) ; $i++)
          {
              $response.= $error[$i] . "<br>";
          }

          echo json_encode(array("status"=>200 , "data"=>$response));
      }


        
    }


}
else
{
    json_decode(array("status"=>201, "data"=>"wrong action"));
}