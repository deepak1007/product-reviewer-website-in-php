<?php

session_start();
include "../config/dbconnect.php";

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action'] == 'sendmessage')
{
   if(isset($_POST['receiver_public_id']) && isset($_POST['message']))
   {
    try{


        date_default_timezone_set('Asia/Kolkata');
    $smt  = $con->prepare("select user_public_id from login where user_id=?");
    $smt->execute(array($_SESSION['user_id']));
    $row = $smt->fetch();
    $sender_public_id = htmlspecialchars($row['user_public_id']);

    $receiver_public_id = htmlspecialchars($_POST['receiver_public_id']);
    $message_id = md5(htmlspecialchars(rand(0,1000).time('H:i:s').date('d')));
    $message = htmlspecialchars($_POST['message']);
    $date = date('Y-m-d');
    
    $time = date('H:i:s');
    
    $query = "insert into chating values(NULL,?,?,?,?,?,?,0)";
    $smt = $con->prepare($query);
    $smt->execute(array($sender_public_id,$receiver_public_id,$message_id, $message, $time, $date));
    if($smt->rowCount() > 0)
    {
      $response = " <div class='outgoing_msg'>
      <div class='sent_msg'>
        <p>". $message . "</p>
        <span class='time_date'>" . $time ."   |    " . $date . " </span> </div>
    </div>";
    echo json_encode(array('status'=>200, 'data'=>$response));

    }
   
  
    
    
    }
    catch(PDOException $e)
    {
        echo json_encode(array('status'=>200, 'data'=>$e->getMessage()));
    }
    
    



   }

}
else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action']=='reloadnew')
{
  try{
    $response = "";
    $smt = $con->prepare('select user_public_id from login where user_id=?');
    
    $smt->execute(array($_SESSION['user_id']));
    $row = $smt->fetch();
    $current_user_public_id = $row['user_public_id'];
    
    $smt = $con->prepare("select receiver_public_id as receiver_id, sender_public_id as sender_id from chating where sender_public_id=? or receiver_public_id=? order by date desc, time desc");
    $smt->execute(array($current_user_public_id, $current_user_public_id));
    $unique_check = array();


    while($row = $smt->fetch())
    { 
      $innerquery = '';
      $other_user_public_id = '';
      if($row['receiver_id'] == $current_user_public_id)
      { 
        $other_user_public_id = $row['sender_id'];
        if(!array_key_exists($other_user_public_id,$unique_check))
        {
            $unique_check[$other_user_public_id] = '1';
        }
        else
        {
          continue;
        }
        $innerquery = 'select message, time, date from chating where sender_public_id=? and receiver_public_id=? and date=(select MAX(date) from chating where (sender_public_id=? and receiver_public_id=?) or (receiver_public_id=? and sender_public_id=?)) and time = (select MAX(time) from chating where (sender_public_id=? and receiver_public_id=?) or (receiver_public_id=? and sender_public_id=?))';
      
      }
      else
      {    
        $other_user_public_id = $row['receiver_id'];
    
        if(!array_key_exists($other_user_public_id,$unique_check))
        {
            $unique_check[$other_user_public_id] = '1';
            
            
        }
        else
        { 
          continue;
        }
        
        $innerquery = 'select message, time, date from chating where receiver_public_id=? and sender_public_id=?  and date=(select MAX(date) from chating where (receiver_public_id=? and sender_public_id=?) or (sender_public_id=? and receiver_public_id=?)) and time = (select MAX(time) from chating where (receiver_public_id=? and sender_public_id=?) or (sender_public_id=? and receiver_public_id=?))';
      }
    
    $innersmt1 = $con->prepare("select * from login where user_public_id=?");
    $innersmt1->execute(array($other_user_public_id));
    $userdetailrow = $innersmt1->fetch();
    $innersmt = $con->prepare($innerquery);
    $innersmt->execute(array($other_user_public_id, $current_user_public_id, $other_user_public_id, $current_user_public_id, $other_user_public_id, $current_user_public_id, $other_user_public_id, $current_user_public_id,$other_user_public_id, $current_user_public_id));
    $messagerow = $innersmt->fetch();

    if($messagerow['message']=='')
    {  
      unset($unique_check[$other_user_public_id]);
       continue;

    }

 
   $response.=" <div class='chat_list' style='cursor:pointer' data-id='".$other_user_public_id ."' onclick='openchats(this)'>
    <div class='chat_people'>
      <div class='chat_img'> <img src='https://ptetutorials.com/images/user-profile.png' alt='sunil'> </div>
      <div class='chat_ib'>
        <h5>". $userdetailrow['user_name'] ."<span class='chat_date'>". $messagerow['date'] ."</span></h5>
        <p>".$messagerow['message'] ."</p>
      </div>
    </div>
  </div>";

}

echo json_encode(array('status'=>200, 'data'=>$response));

}
catch(PDOException $e)
{
  echo json_encode(array('status'=>201,'data'=>$e->getMessage()));
}


}
else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action'] == 'getmessages')
{
    if(isset($_POST['other_user_public_id']))
    {  try{
        $smt = $con->prepare('select user_public_id from login where user_id=?');

        $smt->execute(array($_SESSION['user_id']));
        $row = $smt->fetch();
        $current_user_public_id = $row['user_public_id'];
      $other_user_public_id = $_POST['other_user_public_id'];
      
      $innersmt1 = $con->prepare("select * from login where user_public_id=?");
      $innersmt1->execute(array($other_user_public_id));
      $userdetailrow = $innersmt1->fetch();
      $pro_pic  = $userdetailrow['profile_picture'] ==''? 'images/question.jpg': $userdetailrow['profile_picture'];

      $query  = "select * from chating where (sender_public_id=? and receiver_public_id=?) or (sender_public_id=? and receiver_public_id=?)";
      $smt = $con->prepare($query);
      $smt->execute(array($other_user_public_id, $current_user_public_id, $current_user_public_id , $other_user_public_id));
    $response = '';
      while($row= $smt->fetch())
      {   
          if($row['read_status'] == 0 )
          {
              $smt2 = $con->prepare('update chating set read_status=1 where message_id=?');
              $smt2->execute(array($row['message_id']));

          }

         if($row['sender_public_id'] == $current_user_public_id)
         {
           
                $response.= "<div class='outgoing_msg '>
                <div class='sent_msg'>
                  <p class='lastmessageclass'>". $row['message'] . "</p>
                  <span class='time_date'>". $row['time'] . "  |  " .  $row['date'] ." </span> </div>
              </div>";



         }
         else
         {
             $response.= " <div class='incoming_msg'>
             <div class='incoming_msg_img'> <img src='".$pro_pic."' alt='". $userdetailrow['user_name'] . "'> </div>
             <div class='received_msg'>
               <div class='received_withd_msg'>
                 <p class='lastmessageclass'>".$row['message'] . "</p>
                 <span class='time_date'>". $row['time'] . "  |  " . $row['date'] . "</span></div>
             </div>
           </div>";
         }
           


      }

      echo json_encode(array('status'=>200, 'data'=>$response));


    }
    catch(PDOException $e)
   {
       echo json_encode(array('status'=>201, 'data'=>$e->getMessage()));
   }

    }
    else
    {
        echo json_encode(array('status'=>201, 'data'=>'important variable not set dear'));
    }
}

else
{

}

