<?php
session_start();
include "config/dbconnect.php"; 
include "restapis/cookiecontroler.php";
if(!isset($_SESSION['user_id']))
{?>
   <script>
   alert('please login first');
   window.location.href='index.php' </script>
<?php }
try{
$smt = $con->prepare('select user_public_id from login where user_id=?');

$smt->execute(array($_SESSION['user_id']));
$row = $smt->fetch();
$current_user_public_id = $row['user_public_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link rel='stylesheet' href='chatcss.css'>
<link rel="stylesheet" type="text/css" href="style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>


<style>
  *{z-index:10}
#bg {background:url('images/girl.jpg'); background-position-y:70%;  background-size:cover; }
    #bg #backg {height:55vh;}
    #texture {background:url('images/68.jpg');background-blend-mode: screen; background-size:cover;}
    #texture-2  {background:url('images/3417081 (2).jpg');background-blend-mode: screen; background-size:cover;}
    .heading {height:100% !important; }
    .h { font-size:45px;}
    .font-1 {font-size:22px;}
    .font-2 {font-size:25px;}
    .font-3 {font-size:30px}
    .font-4 {font-size:34px}
    .font-5 {font-size:40px;}
    .font-6 {font-size :43px;}
    .mt-md-6 {margin-top:70px;}
</style>
    </head>
<body>
<?php include "headerfooter/header.php"; ?>
<div class="container">
<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">

        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
           <!-- <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>-->
          </div>
          <div class="inbox_chat">
         <?php 
              
           if(!isset($_GET['one_receiver'])){
           $smt = $con->prepare("select receiver_public_id as receiver_id, sender_public_id as sender_id from chating where sender_public_id=? or receiver_public_id=? order by date desc, time desc limit 0, 15");
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
                    $innerquery = 'select message, time, date, receiver_public_id, read_status from chating where sender_public_id=? and receiver_public_id=? and date=(select MAX(date) from chating where (sender_public_id=? and receiver_public_id=?) or (receiver_public_id=? and sender_public_id=?)) and time = (select MAX(time) from chating where (sender_public_id=? and receiver_public_id=?) or (receiver_public_id=? and sender_public_id=?))';
                  
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
                    
                    $innerquery = 'select message, time, date , receiver_public_id, read_status from chating where receiver_public_id=? and sender_public_id=?  and date=(select MAX(date) from chating where (receiver_public_id=? and sender_public_id=?) or (sender_public_id=? and receiver_public_id=?)) and time = (select MAX(time) from chating where (receiver_public_id=? and sender_public_id=?) or (sender_public_id=? and receiver_public_id=?))';
                  }
                
                $innersmt1 = $con->prepare("select * from login where user_public_id=?");
                $innersmt1->execute(array($other_user_public_id));
                $userdetailrow = $innersmt1->fetch();
                $user_pro_pic = $userdetailrow['profile_picture']==''?'images/question.jpg' : $userdetailrow['profile_picture'];
                $innersmt = $con->prepare($innerquery);
                $innersmt->execute(array($other_user_public_id, $current_user_public_id, $other_user_public_id, $current_user_public_id, $other_user_public_id, $current_user_public_id, $other_user_public_id, $current_user_public_id,$other_user_public_id, $current_user_public_id));
                $messagerow = $innersmt->fetch();

                if($messagerow['message']=='')
                {  
                  unset($unique_check[$other_user_public_id]);
                   continue;

                }
                $read_noti = 0;
                if($messagerow['receiver_public_id']==$current_user_public_id && $messagerow['read_status'] == 0)
                { 
                      $read_noti= 1;   
                }
                
        ?>
            <div class="chat_list" <?php echo $read_noti==1?"style='cursor:pointer;border-left:5px solid green'":"style='cursor:pointer;'";?> data-id='<?php echo $other_user_public_id ?>' onclick='openchats(this)'>
              <div class="chat_people">
                <div class="chat_img"> <img src="<?php echo $user_pro_pic?>" alt="<?php echo $userdetailrow['user_name']?>"> </div>
                <div class="chat_ib">
                  <h5><?php echo $userdetailrow['user_name'] ?><span class="chat_date"><?php echo $messagerow['date'] ?></span></h5>
                  <p><?php echo $messagerow['message']?></p>
                </div>
              </div>
            </div>


            <?php
                }}}
                catch(PDOException $e)
                {
                  echo $e->getMessage();
                }
                ?>
           <!-- <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>-->
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history" data-id='<?php echo isset($_GET['one_receiver'])?$_GET['one_receiver']:""?>'>
            <?php
            if(isset($_GET['one_receiver']))
            {
              try{
                $smt = $con->prepare('select user_public_id from login where user_id=?');
        
                $smt->execute(array($_SESSION['user_id']));
                $row = $smt->fetch();
                $current_user_public_id = $row['user_public_id'];
              $other_user_public_id = $_GET['one_receiver'];
              
              $innersmt1 = $con->prepare("select * from login where user_public_id=?");
              $innersmt1->execute(array($other_user_public_id));
              $userdetailrow = $innersmt1->fetch();
        
              $query  = "select * from chating where (sender_public_id=? and receiver_public_id=?) or (sender_public_id=? and receiver_public_id=?) order by serial_no asc limit 0 , 20";
              $smt = $con->prepare($query);
              $smt->execute(array($other_user_public_id, $current_user_public_id, $current_user_public_id , $other_user_public_id));
            
              while($row= $smt->fetch())
              {   
                  if($row['read_status'] == 0 )
                  {
                      $smt2 = $con->prepare('update chating set read_status=1 where message_id=?');
                      $smt2->execute(array($row['message_id']));
        
                  }
        
                 if($row['sender_public_id'] == $current_user_public_id)
                 {
                   
                        echo  "<div class='outgoing_msg'>
                        <div class='sent_msg'>
                          <p>". $row['message'] . "</p>
                          <span class='time_date'>". $row['time'] . "  |  " .  $row['date'] ." </span> </div>
                      </div>";
        
        
        
                 }
                 else
                 {
                     echo " <div class='incoming_msg'>
                     <div class='incoming_msg_img'> <img src='https://ptetutorials.com/images/user-profile.png' alt='". $userdetailrow['user_name'] . "'> </div>
                     <div class='received_msg'>
                       <div class='received_withd_msg'>
                         <p>".$row['message'] . "</p>
                         <span class='time_date'>". $row['time'] . "  |  " . $row['date'] . "</span></div>
                     </div>
                   </div>";
                 }
                   
        
        
              }
        
              
        
        
            }
            catch(PDOException $e)
           {
               echo $e->getMessage();
           }
            }
            ?>
          <!--  <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test which is a new approach to have all
                    solutions</p>
                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Hello mother bete</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test, which is a new approach to have</p>
                  <span class="time_date"> 11:01 AM    |    Yesterday</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Apollo University, Delhi, India Test</p>
                <span class="time_date"> 11:01 AM    |    Today</span> </div>
            </div>
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>We work directly with our designers and suppliers,
                    and sell direct to you, which means quality, exclusive
                    products, at a price anyone can afford.</p>
                  <span class="time_date"> 11:01 AM    |    Today</span></div>
              </div>
            </div>-->
          </div>
          <div class="type_msg"  <?php echo isset($_GET['one_receiver'])?"style='display:block'":"style='display:none'"?>>
            <div class="input_msg_write">
              <?php
              include "emoji.php" 
              ?>
              <input type="text" class="write_msg"  id='message' placeholder="Type a message" />
              <button class="msg_send_btn" type="button" onclick="send_message()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
              </div>
<?php 
if(isset($_GET['one_receiver']))
{
  echo "<script> var reload_flag=1; </script>";

}
else
{
  echo "<script> var reload_flag=0; </script>";
}
?>
      <script>

     



       var receiver_id  = '';
       function send_message()
       {
           var message = document.getElementById('message').value;
           if(message != '')
           {
            receiver_id= document.getElementsByClassName('msg_history')[0].dataset.id;
           var formdata = new FormData();
           formdata.append('receiver_public_id', receiver_id);
           formdata.append('message', message);

           var con  = new XMLHttpRequest();
           con.onreadystatechange = function(){
                if(con.readyState == 4)
                {
                    
                    var response = JSON.parse(con.responseText);
                    if(response['status']==200)
                    {
                        var chat_box = document.getElementsByClassName('msg_history')[0];
                        chat_box.innerHTML = chat_box.innerHTML + response['data'];
                        document.getElementById('message').value = "" ;
                        /* from here we change the text in the chat list ... the last texted person will become the first in the chat list(inbox_chat)... if he is already at top then ok if not then we will bring it at top by choosing the inbox_chat then the first child and then we will iterate over every child of inbox_chat and then change their innerText of p tag in them to the latest text of the person*/
                        var inbox = document.getElementsByClassName('inbox_chat')[0];
                        var t = inbox.firstElementChild;

                        i=0;
                        while(t)
                        {   if(t.dataset.id== receiver_id)
                            {
                              var p = t.querySelector('.chat_ib > p');
                              var last_text = chat_box.getElementsByClassName('outgoing_msg');
                               last_text = last_text[last_text.length-1];
                              var text_in_last_text = last_text.querySelector('.sent_msg > p')
                              p.innerText = text_in_last_text.innerText;
                              if(i != 0)
                              {
                                  var temp_t = t;
                                 inbox.removeChild(t);
                                 inbox.innerHTML = temp_t.outerHTML + inbox.innerHTML;

                              }
                              else
                              {

                              }

                            }
                             
                            i = i+1;
                            t = t.nextElementSibling;
                        }

                        if(reload_flag)
                        {
                          window.location.href='chatbox.php';
                        }
                        
                    }
                    else
                    {

                    }
                }

           }

           con.open('POST', 'restapis/chatapi.php?action=sendmessage', 1);
           con.send(formdata);
           }

       }
      
      function openchats(t)
      {
         
         var other_user_public_id = t.dataset.id;
         var formdata = new FormData();
         formdata.append("other_user_public_id", other_user_public_id);
         $('.chat_list').css("border-left", "0px");
         t.style.borderLeft = '5px solid green';
         var con = new XMLHttpRequest();
         con.onreadystatechange = function(){
            if(con.readyState == 4)
            {
              
              var response = JSON.parse(con.responseText);
              if(response["status"]==200)
              { 
                var msg_history = document.getElementsByClassName('msg_history')[0];
                msg_history.innerHTML = response['data'];

                receiver_id = other_user_public_id;
                document.getElementsByClassName('type_msg')[0].style.display = "block";

                msg_history.setAttribute('data-id' , other_user_public_id);

                msg_history.onclick = function(){
        document.getElementsByClassName('emoticons')[0].style.display = 'none';
      }

                document.getElementsByClassName("write_msg")[0].onclick = function(){
        document.getElementsByClassName('emoticons')[0].style.display = 'none';
      }
     
     
      document.getElementsByClassName('emoticons')[0].style.display = 'none';
      
     
      

                   
              }
              else
              {
                 alert(response['data']);
              }
            }
         }

         con.open('POST', 'restapis/chatapi.php?action=getmessages' , 1);
         con.send(formdata);



      }
      

      function reload_new_chat()
      {
        var con = new XMLHttpRequest();
        con.onreadystatechange = function()
        {
          if(con.readyState == 4)
          {
            
            var response = JSON.parse(con.responseText);
            if(response['status']== 200)
            {
              var inbox = document.getElementsByClassName('inbox_chat')[0];
              inbox.innerHTML = response['data'];
            }
            else
            {
              alert(reponse['data']);
            }
           
            
          }
        }
        con.open('GET', 'restapis/chatapi.php?action=reloadnew', 1);
        con.send();
      }

 setInterval(reloadopenchats, 30000);
      
      function reloadopenchats()
      {
        
         var other_user_public_id = document.getElementsByClassName('msg_history')[0].dataset.id;
         if(other_user_public_id != "")
        { var formdata = new FormData();
        console.log(other_user_public_id);
         formdata.append("other_user_public_id", other_user_public_id);
        
         var con = new XMLHttpRequest();
         con.onreadystatechange = function(){
            if(con.readyState == 4)
            {
             
              var response = JSON.parse(con.responseText);
              if(response["status"]==200)
              { 
                var msg_history = document.getElementsByClassName('msg_history')[0];
                msg_history.innerHTML = response['data'];

            

                var lastmessage = document.getElementsByClassName('lastmessageclass');
                lastmessage = lastmessage[lastmessage.count - 1];
             
                var inbox = document.getElementsByClassName('inbox_chat')[0];
                var t = inbox.firstElementChild;

                t.getElementsByTagName('p')[0].innerText = lastmessage.innerText;

                receiver_id = other_user_public_id;
               
               
              }
              else
              {
                 alert(response['data']);
              }
            }
         }
         con.open('POST', 'restapis/chatapi.php?action=getmessages' , 1);
         con.send(formdata);
        }

      }

      function sendemoji(t)
       {
         var write_box = document.getElementsByClassName('write_msg')[0];
         write_box.value = write_box.value + t.innerText;
       }
     
      
      </script>

      
      
     <!-- <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>-->
      
    </div>
</div>
    </body>
    </html>