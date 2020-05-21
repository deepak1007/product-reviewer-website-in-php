<?php
session_start();
require_once "config/dbconnect.php";
if(!isset($_SESSION['user_id']))
{?>
   <script>
   alert('please login first');
   window.location.href='index.php' </script>
<?php }
$query ='';
$user_id ="";
try{
if(isset($_GET['user']))
{
  $user_id=htmlspecialchars($_GET['user']);
  $smt = $con->prepare('select user_id from login where user_public_id =?');
  $smt->execute(array($user_id));
  $user_id = $smt->fetch()['user_id'];

}
else
{
  $user_id = $_SESSION['user_id'];
 
}
$query = "select * from login where user_id=?";
$smt = $con->prepare($query);
$row = '';
if(isset($user_id))
{
  $smt->execute(array(htmlspecialchars($user_id)));
  $row = $smt->fetch();
}
else
{
  header('Location:index.php');
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>
    <title>Document</title>
    <style>
        .propic { 
            width:200px; height:180px; position:relative; 
        }
        .img {width:100%; height:100%}
        .img img{ width:100%; height:100%;}
        .overlay{position:absolute; top:0 ; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5) }
        .overlay button { appearance:none; border-radius:50%;position:absolute; width:40px ; height:40px; top:50%; left:50%; transform:translate(-50%,-50%)}
        .overlay input[type='file'] {visibility: hidden}
        
        .over { overflow:auto; width:100%; white-space:nowrap;display:inline-block !important;}
        .over li{display:inline-block}
        .over li a {font-size:15px;}

        #menu1 a {color:black; text-decoration:none;}
      /*used for centering images and divs */
       @media (max-width:970px) {
         .min-center-50 { width:50% ; margin:auto;}
         .min-center-60 { width:60% ; margin:auto;}
         .min-center-70 { width:70% ; margin:auto;}
         .min-center-80 { width:80% ; margin:auto;}
         .min-center-90 { width:90% ; margin:auto;}
         .min-center-100 { width:100% ; margin:auto;}
         

       }
       @media (max-width:580px) {
         .min-center-xs-50 { width:50% ; margin:auto;}
         .min-center-xs-60 { width:60% ; margin:auto;}
         .min-center-xs-70 { width:70% ; margin:auto;}
         .min-center-xs-80 { width:80% ; margin:auto;}
         .min-center-xs-90 { width:90% ; margin:auto;}
         .min-center-xs-100 { width:100% ; margin:auto;}
         

       }


     </style>

</head>
<body style='background:rgba(220,220,220,0.1)'>
    <?php include "headerfooter/header.php" ?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-12"><!--pro pic selector and name-->
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-lg-2 offset-xl-1"><!-- size = 1 col for img-->               
                               
                                 <div style='overflow:hidden;width:150px; height:150px;' class='min-center-xs-50'><!--image-->
                                 <img src="<?php echo ($row['profile_picture']!='')?$row['profile_picture']:'images/question.jpg' ?>" style='width:100%;' alt="">
                                </div>
                                <div><h5 class='text-center'><?php echo "@" . $row['user_id']; ?> <!-- name through php --></h5></div>
                            <?php if($row['user_id']!=$_SESSION['user_id'])
                            {
                              ?>
                            
                                <h5 class='text-center'><small><a style='text-decoration:none' href='chatbox.php?one_receiver=<?php echo $row['user_public_id'] ?>'><i class="fa fa-comments" aria-hidden="true"></i>&nbsp; send message</a></small></h5>
                              <?php 
                            }
                            ?>
                    
                    </div>
                    <div class="col-xs-12 col-sm-4 col-lg-4"> 
                       
                       <h5><small>Full Name:&nbsp;<?php echo $row['user_name']; ?></small></h5>
                     <!--<h5><small>age : <?php //echo date('y', time()-strtotime($row['date_of_birth'])); ?></small></h5>
      -->
      <h5><small>State:&nbsp;<?php echo $row['state']; ?></small></h5>
      <?php 
      $total_activ = 0;
      $count_activities = $con->prepare("select count(*) from posts where user_id=?");
      $count_activities->execute(array($user_id));
      $post_count = $count_activities->fetch()['count(*)'];
      $count_activities = $con->prepare("select count(*) from comments where user_id=? and replyto=''");
      $count_activities->execute(array($user_id));
      $comment_count = $count_activities->fetch()['count(*)'];
      $total_activ = $post_count + $comment_count;
?>
                       <h5><small>Total Activities : <?php echo $total_activ; ?></small></h5>
                     
                      <?php
                      $total_views = 0;
                     $views_row = $con->prepare('SELECT sum(views) from posts where user_id=?');
                     $views_row->execute(array($user_id));
                     $total_views = $views_row->fetch()['sum(views)'];
?>

                   </div>
                    <div class="col-xs-12 col-sm-5"> 
                       
                        <h5><small>Date Joined : <?php echo date('d-M-Y',$row['date_of_joining']); ?></small></h5>
                        <!--<h5><small>profile views : <?php //echo $row['profile_view']; ?></small></h5>-->
                        <h5><small>content views : <?php echo $total_views; ?></small></h5>
                        
                        <!--<h5><small>ranking : <?php echo "0"; ?></small></h5>-->

                    </div>
                   
                </div>
            </div>
           
            <div class="col-12 col-lg-10 offset-xl-1 mt-4">
                
                    <!-- Nav pills -->
                    <ul class="nav nav-tabs over" role="tablist">
                      <?php 
                      if(!isset($_GET['user']))
                      {
                        ?>
    <li class="nav-item left-border">
      <a class="nav-link active" data-toggle="tab" href="#home">Edit Profile</a>
    </li>
    <?php
                      }

      $smt1 = $con->prepare('select count(*) from posts where user_id=?');
      $smt1->execute(array($user_id));
      $postcount = $smt1->fetch();
      $postcount = $postcount['count(*)'];

      $smt2 = $con->prepare('select count(comment_id) as commentscount from comments where user_id=?');
      $smt2->execute(array($user_id));
      $commentscount = $smt2->fetch()['commentscount'];
                      ?>


    <li class="nav-item left-border" >
      <a class="nav-link" data-toggle="tab" href="#menu1">Reviews <?php echo $postcount ?></a>
      
    </li>
    <li class="nav-item left-border">
      <a class="nav-link" data-toggle="tab" href="#menu2">Questions <?php echo "0" ?></a>
    </li>
    <li class="nav-item left-border">
      <a class="nav-link" data-toggle="tab" href="#menu3">Answers <?php echo $commentscount ?></a>
    </li>
   <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu3">Miscs</a>
    </li>-->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  <?php 
                      if(!isset($_GET['user']))
                      {  $name= explode(" ", $row['user_name']);
                        
                        
                        ?>
    <div id="home" class="container tab-pane active"><br>
     <div class="row">
         <div class="col-md-6">
         <form class='mb-lg-5' id='submit-changes-form'>
             First Name : </br><input type="text" name="firstname" class='w-100' id="" value='<?php echo $name[0]; ?> '><br><br/>
             Last Name : <br/><input type="text" class='w-100' name="lastname" id="" value='<?php echo $name[2]; ?>'><br><br/>
             Email :&nbsp;<?php echo $row['email']; ?> <br/> <br/>
             Phone : <a href='#'>change</a><br/><input type="text" name="phoneno" value='<?php echo $row['phone_no'] ?>' class='w-100' id=""> <br/><br/>
             Username :  <?php echo $row['user_id'] ?></br/><br/>
             Address :  <br>
            <textarea class='w-100' name="address" id="" cols="30" rows="3"><?php echo $row['address']; ?></textarea><br/><br/>
            State :<br> <input type="text" class='w-100' name="state" id="" value='<?php echo $row['state']; ?>'>
              
         </form>
         </div>
         <div class="col-12 col-md-5 col-lg-3 mt-5 mt-md-0 offset-lg-2"> <!--centering the image -->
             <div class="propic min-center-60"> <!-- centering images -->
                 <div class="img" >
                 <img src="<?php echo ($row['profile_picture']!='')?$row['profile_picture']:'images/question.jpg' ?>" id='image_of_profile_pic' alt="">
                 </div>
                 <div class="overlay">
                     <input type="file" name="dp" id="input">
                    <button type='button' onclick='takeinput();'>c</button>
                 </div>
             </div>
              <button class='btn btn-success mt-3' style='position:relative; left:50%; transform:translateX(-50%)' onclick='submitChanges()'>Submit Changes</button> 
            
         </div>
     </div>
        
    </div>
    <?php
                      }
                      ?>
                     
  
    <div id="menu1" class="container tab-pane <?php echo isset($_GET['user'])?"active": "fade";?> "><br>
   
    <?php
    $query2 = "select * from posts where user_id=?";
    $smt = $con->prepare($query2);
    $smt->execute(array($user_id));
    $count = $smt->rowCount();
    if($count>0)
    {
    while($post = $smt->fetch())
    {?>
    <a href='postread.php?post_id=<?php echo $post['post_id']; ?>' title='go to page'>
    <div class='profile-activities'>

    <h5><?php echo $post['post_heading'] ?> <small>- posted on <?php echo date('d-M-Y', $post['post_date']) ?> </small></h5>
    
    <p><?php echo substr(strip_tags($post['post_content']),0,200) . "..."; ?></p>
      
    
    <div>
      <ul class='list-inline'>
        <li class='list-inline-item'><i class='fa fa-arrow-up'></i>&nbsp;<?php echo $post['upvotes']; ?></li>
        <li class='list-inline-item'><i class='fa fa-arrow-down'></i>&nbsp;<?php echo $post['downvotes'] ?></li>
        <li class='list-inline-item'><i class='fa fa-flag' aria-hidden="true"></i>&nbsp;<?php echo $post['downvotes'] ?></li>
      </ul>
    </div>
   
    </div>
    </a>
    
   <?php 
    }}
    else
    {
    ?>
    <h4 class='text-center'>sorry no reviews till now</h4>
    <?php 
    }
    ?>
   </div> 
   


    <div id="menu2" class="container tab-pane fade"><br>
    <?php
    $query2 = "select * from posts where user_id=? and question_flag=1";
    $smt = $con->prepare($query2);
    $smt->execute(array($_SESSION['user_id']));
    $count = $smt->rowCount();
    if($count>0)
    {
    while($question = $smt->fetch())

    {?>
     <a href='postread.php?post_id=<?php echo $question['post_id']; ?>' title='go to page'>
    <div class='profile-activities'>
    <h5>posted on <?php echo date('d-M-Y', $question['post_date']) ?> </h5>
    
      <h3><small><?php echo $question['post_heading'] ?></small></h3>
   
    <div>
      <ul class='list-inline'>
        <li class='list-inline-item'><i class='fa fa-arrow-up'></i>&nbsp;<?php echo $question['upvotes']; ?></li>
        <li class='list-inline-item'><i class='fa fa-arrow-down'></i>&nbsp;<?php echo $question['downvotes'] ?></li>
        <li class='list-inline-item'><i class='fa fa-flag' aria-hidden="true"></i>&nbsp;<?php echo $question['downvotes'] ?></li>
      </ul>
    </div>
    </div></a>
    <br>
    
    <?php
    }}
    else
    {
    ?>
    <h4 class='text-center'>sorry no questions till now</h4>
    <?php 
    }
    ?>
  
    </div>




    <div id="menu3" class="container tab-pane fade"><br>
    <?php
    
    $query2 ="SELECT c.comment_date, c.comment_id, c.upvotes, c.downvotes, c.reports,  c.post_id, c.content, p.post_heading FROM comments c LEFT JOIN posts p on c.post_id = p.post_id where c.user_id=? AND replyto=''";
    $smt = $con->prepare($query2);
    $smt->execute(array($user_id));
    $count = $smt->rowCount();
    
    if($count>0)
    { 
    while($comment = $smt->fetch())
    { 
      ?>
     <a href='postread.php?post_id=<?php echo $comment['comment_id']; ?>' style='text-decoration:none;color:black'  title='go to page'>
    <div class='profile-activities'>
    <h5><?php echo $comment['post_heading'] ?> <small>- posted on <?php echo date('d-M-Y', $comment['comment_date']) ?> </small></h5>
    <p><?php echo substr(strip_tags($comment['content']), 0, 30); ?></p>
   
    <div>
      <ul class='list-inline'>
        <li class='list-inline-item'><i class='fa fa-arrow-up'></i>&nbsp;<?php echo $comment['upvotes']; ?></li>
        <li class='list-inline-item'><i class='fa fa-arrow-down'></i>&nbsp;<?php echo $comment['downvotes'] ?></li>
        <li class='list-inline-item'><i class='fa fa-flag' aria-hidden="true"></i>&nbsp;<?php echo $comment['downvotes'] ?></li>
      </ul>
    </div>
    </div></a>
    <br>
    
    <?php
    }}
    else
    {
    ?>
    <h4 class='text-center'>sorry no Answers till now</h4>
    <?php 
    }}catch(PDOException $e)
    {
      echo $e->getMessage();
    }
    ?>
    </div>

    

  </div>
              
            </div>

        </div>
    </div>
    <script>
   var profilepic = '';
    function takeinput()
    {
        document.getElementById('input').click();
        
    } 
    
  var input_button = document.getElementById('input');
   
    
    

   input_button.onchange =  function(){
  
       try{ 

            var formdata = new FormData();
            formdata.append("profile_picture", input_button.files[0]);
            var con = new XMLHttpRequest();
                con.onreadystatechange = function(){
                  if(con.readyState==4)
                  {   
                      var response  = JSON.parse(con.responseText);
                      
                      if(response['status'] == "200")
                      {
                          var newimg = document.getElementById('image_of_profile_pic');
                          newimg.setAttribute('src', response['data']);
                          
                       
                       location.reload();
                          
                      }
                      else
                       {
                         alert($response['data']);
                       }
                  }

                }
               con.open('POST', 'restapis/regis.php?action=profilepicupload', true);
               con.send(formdata);
             

        }
        catch(e)
        {
             alert(e);
        }

    }

    function submitChanges()
    {
           var formdata = new FormData();
           var form = document.getElementById('submit-changes-form');
           formdata.append("firstname", form.firstname.value);
           formdata.append("lastname", form.lastname.value);
           formdata.append("address", form.address.value)
           formdata.append("state",form.state.value);

           var con = new XMLHttpRequest();
           con.onreadystatechange = function(){
             if(con.readyState == 4)
             {
                 var response = JSON.parse(con.responseText);
                 if(response['status']== 200)
                 {
                    alert(response['data']);
                   location.reload();
                 }
                 else
                 {
                   alert(response['data']);
                 }
             }
           }
           con.open("POST", "restapis/regis.php?action=changes", 1)
           con.send(formdata);
    }


    $('.left-border').click(function(){

      $(this).css('border-left','3px solid green');
      $(this).siblings().css('border-left', '0px');

    });
    </script>

<?php include "headerfooter/footer.php"?>
</body>
</html>