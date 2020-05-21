<?php
session_start();

include "config/dbconnect.php";

function filter($querystring)
{
    $querystringfilterarray = explode(' ', $querystring);
    $filters = array("in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then", "is" ,"what", "how" , "not", "could");
    $filtered = array();
    foreach($querystringfilterarray as $value)
    {
         if(!in_array($value, $filters))
         {
             $filtered[] = $value;
         }
    }
    return $filtered;
}
//for adding to reaction 
$reaction_check = $con->prepare('select count(*) from reaction where post_id=?');
$reaction_check->execute(array(htmlspecialchars($_GET['post_id'])));
$reaction_check_row = $reaction_check->fetch();

if($reaction_check_row['count(*)']==0)
{
    $query = "update posts set views = views  + 1 where post_id=?";
    $query_for_reaction = "insert into reaction values(NULL, :user_id, :post_id , '', 0, 0, 0 , 1)";
    $both = $con->prepare($query);
    $result = $both->execute(array(htmlspecialchars($_GET['post_id'])));
    if($result)
    {
        $both = $con->prepare($query_for_reaction);
        $result = $both->execute(array('user_id'=>$_SESSION['user_id'], 'post_id'=> htmlspecialchars($_GET['post_id'])));
    }
}
$row = 0;
$postid="";
$post_user_id = '';
if(isset($_GET['post_id']))
{
     $postid = htmlspecialchars($_GET['post_id']);
     
     $query = "select * from posts where post_id = ?";
     $smt = $con->prepare($query);
     $smt->setFetchMode(PDO::FETCH_ASSOC);

     $smt->execute(array($postid));

     $row = $smt->fetch();
     $post_user_id = $row['user_id'];

     $query = "select * from comments where post_id=? and replyto=''";
     $smtcomment = $con->prepare($query);
     $smtcomment->setFetchMode(PDO::FETCH_ASSOC);
     $smtcomment->execute(array($_GET['post_id']));


    
    $query1 = "select count(*), upvote, downvote,report from reaction where user_id=? and post_id=?";
    $innersmt1 = $con->prepare($query1);
    $innersmt1->execute(array($_SESSION['user_id'], $_GET['post_id']));
    $innerrow1 = $innersmt1->fetch();
    $post_upvote_flag= $post_downvote_flag = $post_report_flag =0 ;
    if($innerrow1['count(*)'] >0 )
         {
               $post_upvote_flag = $innerrow1['upvote'] ;
               $post_downvote_flag = $innerrow1['downvote'];
               $post_report_flag = $innerrow1['report'];
          }




  

  



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    <script src='app.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>
 
    <title>Document</title>
</head>

<body  style='background:rgba(220,220,220,0.1)'>
    <?php 
    include "headerfooter/header.php";
    include "login.php" ;
    include "signup.php";
    ?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12 order-1 order-md-0 col-md-3 border-right">
                <!--for topics suggestions -->
                <h4 class='mt-4'>Suggestions</h4>
                <hr>

              <?php
            
               try { 
                   
               
               $topic_string  = trim($row['post_heading']);
               $topic_string_keywords = filter($topic_string);
               
               $where_constraints = '';
               $x = 0;
               foreach($topic_string_keywords as $value)
               {
                   if($x==0)
                   {
                       $where_constraints.=" post_heading like '%$value%' ";
                   }
                   else
                   {
                       $where_constraints.=" and post_heading like '%$value%' ";
                   }
                   $x++;
               }
               $query = "select * from posts where " . $where_constraints . " order by upvotes desc, downvotes asc limit 0 , 10";
               $smtsuggest = $con->prepare($query);
               $smtsuggest->execute();
              
               while($suggested_topic_row = $smtsuggest->fetch())
               {
                    $post_heading = $suggested_topic_row['post_heading'];
                    if($post_heading == $row['post_heading'])
                    {
                        continue;
                    }
                    ?>

                <div class='suggested_topic_link_box mb-2'>
                    <a href='postread.php?post_id=<?php echo $suggested_topic_row['post_id']?>' title='read this topic'><?php echo $post_heading ?></a>
                </div> 
              
            <?php
               }
               
               $query = "select * from posts where category=".$row['category']." order by upvotes desc, downvotes asc limit 0 , 10";
               $smtsuggest = $con->prepare($query);
               $smtsuggest->execute();
              
               while($suggested_topic_row = $smtsuggest->fetch())
               {
                    $post_heading = $suggested_topic_row['post_heading'];
                    if($post_heading == $row['post_heading'])
                    {
                        continue;
                    }?>
                     <div class='suggested_topic_link_box mb-2'>
                    <a href='postread.php?post_id=<?php echo $suggested_topic_row['post_id']?>' title='read this topic'><?php echo $post_heading ?></a>
                </div> 
            <?php
               }
            
            }catch(PDOException $e)
               {
                   
               }
            ?>
            </div>

            <div class='col-12 col-md-6  post-box'>
                <!--for post -->
                 
                     <div class="post_head my-4">
                         <!-- heading -->
                         <?php 
                           echo "<h2>".$row['post_heading'] . "</h2>";
                           ?>
                     </div>
                     <div class="post_content">
                         <!-- content -->
                         <?php 
                         echo $row['post_content'];
                         ?>

                     </div>
                   
                
                     <div class="post_features mt-5">
                         <!-- post features -->
                         <div>
                         <ul class='list-inline'  id='post-reaction' data-postid = '<?php echo $_GET['post_id']; ?>'>
                        
                         <li class='list-inline-item ' style='cursor:pointer' onclick='post_reaction(this)' data-action='upvote'><!--<i class='fa fa-arrow-up' aria-hidden='true'></i>--> <i class='fa fa-arrow-up animator' <?php echo ($post_upvote_flag==1)?"style='color:green'":"style='color:black'"; ?>></i>&nbsp;<p style='display:inline-block'><?php echo $row['upvotes'] ; ?></p></li>

                         <li class='list-inline-item' style='cursor:pointer' onclick='post_reaction(this)' data-action='downvote' ><i class='fa fa-arrow-down' <?php echo ($post_downvote_flag==1)?"style='color:orange'":"style='color:black'"; ?>></i>&nbsp;<p  style='display:inline-block'><?php echo $row['downvotes'] ; ?></p></li>

                         <li class='list-inline-item' style='cursor:pointer' onclick='post_reaction(this)' data-action='report'><i class='fa fa-flag animator' aria-hidden="true" <?php echo ($post_report_flag==1)?"style='color:red'":"style='color:black'"; ?>></i>&nbsp;<p  style='display:inline-block'><?php echo $row['reports'] ; ?></p></li>
                         </ul>
                         </div>
                         
                     </div>
                 
                <hr>
                     <div class="mb-5" id='comment_post_area'>
                        <form action="">
                        <script src="ckeditorless/ckeditor/ckeditor.js"></script>
                        <textarea name="comment_box" id="comment_box" cols="30" rows="5"></textarea>
                    
                        <button type='button' class='btn btn-success text-uppercase px-5 mt-1' id='comment_post_button' onclick='send()'>post</button>
                        
                       <!-- comment box for comment -->

                        </form>
                     </div>
                     <div id="comment_read_area">
                   <?php
                   $i= 0 ; 
                   while($comment = $smtcomment->fetch())
                   {
                    $query = "select * from login where user_id=?";
                    $innersmt = $con->prepare($query);
                    $innersmt->setFetchMode(PDO::FETCH_ASSOC);
                    $innersmt->execute(array($row['user_id']));
                    $innerrow = $innersmt->fetch();
                    $pro_pic =  $innerrow['profile_picture']==''?'images/question.jpg':$innerrow['profile_picture'];
                    $query = "select count(*), upvote, downvote,report from reaction where user_id=? and comment_id=?";
                    $innersmt = $con->prepare($query);
                    $innersmt->execute(array($_SESSION['user_id'], $comment['comment_id']));
                    $innerrow2 = $innersmt->fetch();
                    $upvote_flag= $downvote_flag = $report_flag =0 ;
                    if($innerrow2['count(*)'] >0 )
                    {
                      $upvote_flag = $innerrow2['upvote'] ;
                      $downvote_flag = $innerrow2['downvote'];
                      $report_flag = $innerrow2['report'];
                    }
                   ?>
                    
                     

                     <div class="media p-3">
                       <img src="<?php echo $pro_pic ?>" alt="John Doe" class="mr-3 mt-3 rounded-circle" style="width:50px;height:50px;">
                      <div class="media-body" id='<?php echo $i ; ?>' data-commentid='<?php echo $comment['comment_id']; ?>' data-type='comment'>
                      <!-- data-type states that we have to react on a post or a comment and commentid is the comment id of the whole block -->
                      <h4><small><a style='text-decoration:none;' href="profile.php?user=<?php echo $innerrow['user_public_id']; ?>" title='visit profile'><?php echo $innerrow['user_name'];?></a></small> &nbsp;<small style='font-size:15px;'><i>-Posted on <?php echo $comment['comment_date'];?> </i></small></h4>
                     <p><?php echo $comment['content']; ?></p>


                     <ul class='list-inline' style='border-left:5px solid orange; padding-top:6px ; background:whitesmoke' >
                         <!-- comment_reaction(this) is a single functin in app.js that controls the reaction on comments. data-action tells wheter to upvote or downvote or report a comment or post and data-no is used to find the ID of the media-body -->
                         <li class='list-inline-item' style='cursor:pointer' onclick='comment_reaction(this)' data-action='upvote' data-no='<?php echo $i; ?>'><!--<i class='fa fa-arrow-up' aria-hidden='true'></i>--> <i class='fa fa-arrow-up' <?php echo ($upvote_flag)?"style='color:green'":"style='color:black'"; ?>></i>&nbsp;<p style='display:inline-block'><?php echo $comment['upvotes'] ; ?></p></li>

                         <li class='list-inline-item' style='cursor:pointer' onclick='comment_reaction(this)' data-action='downvote' data-no='<?php echo $i ?>' ><i class='fa fa-arrow-down' <?php echo ($downvote_flag)?"style='color:orange'":"style='color:black'"; ?>></i>&nbsp;<p  style='display:inline-block'><?php echo $comment['downvotes'] ; ?></p></li>

                         <li class='list-inline-item' style='cursor:pointer' onclick='comment_reaction(this)' data-action='report' data-no='<?php echo $i?>'><i class='fa fa-flag' aria-hidden="true" <?php echo ($report_flag)?"style='color:red'":"style='color:black'"; ?>></i>&nbsp;<p  style='display:inline-block'><?php echo $comment['reports'] ; ?></p></li>


                         <li class='list-inline-item repliesbutton' onclick='changeid(this)' data-commentid="<?php echo $comment['comment_id']; ?> " data-no='<?php echo $i; ?>'> reply </li>
                        <?php if($_SESSION['user_id'] == $comment['user_id'])
                         {?>
                        
                        
                         <li class='list-inline-item repliesbutton' style='color:red;' data-commentid="<?php echo $comment['comment_id']; ?> " onclick='delete_comment(this)' data-no='<?php echo $i; ?>'> delete</li>


                         <?php
                         }
                         ?>
                         <!-- commentid of this comment used when someone clicks on reply or sees all replies no. is the media-body no. that would be used to paste the replies inside right media body -->
                    </ul>

                     <ul class='list-inline'>
                     <li class='list-inline-item' style='cursor:pointer' onclick='withdrawreplies(this)' data-commentid="<?php echo $comment['comment_id']; ?> " data-no='<?php echo $i; ?>' data-action='withdraw'> view all replies </li>
                    </ul>
                    

                      </div>
                     </div>

                   
                  
                     <?php
                     $i++;
                   }
                }
                ?>

</div>

            </div>
        <!-- css in style.css -->

        <?php
        $query = "select * from login where user_id=?";
        $smt = $con->prepare($query);
        $smt->setFetchMode(PDO::FETCH_ASSOC);
        $smt->execute(array($post_user_id));
        $row = $smt->fetch();
        $pro_pic2 =  $row['profile_picture']==''?'images/question.jpg':$row['profile_picture'];
        ?>

         <div class="col-12 col-md-2 " id='writer-details'>
          <h4 class='mt-3'>Writer</h4>
                <hr>
         <div class="profile_picture">
            <img src="<?php echo $pro_pic2?>" alt="profile picture of writer">
        </div>
        <div class='name-username' >
            <h5><small><a href="profile.php?user=<?php echo $row['user_public_id']?>"><i class='fa fa-user' aria-hidden="true"></i>&nbsp;<?php echo $row['user_name'];?></a></small></h5>
        </div>
        <div class='message'>
            <h5 ><small><a href="chatbox.php?one_receiver=<?php echo $row['user_public_id'];?>"><i class='fa fa-comments' aria-hidden="true"></i>&nbsp;Send Message</a></small></h5>
        </div>



         </div>



        </div>
    </div>

<script>

    var comment_box =  CKEDITOR.replace( 'comment_box', {
                         height: '20vh',
                         filebrowserUploadUrl:"upload.php",
                        filebrowserUploadMethod:"form"
                           });


    var cid = '';
    
    var selected_media_body_id = '';


    
 
                        function changeid(t)
                        {
                            var commentid= t.dataset.commentid;
                            cid = commentid;
                            
                           
                            var media_body_no = t.dataset.no;
                            selected_media_body_id = media_body_no;
                           
                        }


                           function send(){
                              
                              var form = document.getElementById('poster-form');
                              var formdata= new FormData();
                              var media_body_count = document.getElementsByClassName('media-body').length ;
                              formdata.append("post_id", "<?php echo $postid; ?>");
                              formdata.append("comment_content", comment_box.getData());
                              formdata.append("replyto", cid);
                              formdata.append("media_body_count", media_body_count );
                        
                              var conn = new XMLHttpRequest();
                              conn.onreadystatechange = function(){
                                  
                                  if(conn.readyState == 4)
                                  {    
                                      var response = JSON.parse(conn.responseText);
                                      
                                      if(response['status']=='200')
                                      {
                                          alert("posted");

                                          if(selected_media_body_id != '')
                                          {
                                              var selected_media_body = document.getElementById(selected_media_body_id);
                                              selected_media_body.innerHTML = selected_media_body.innerHTML + response['data'];
                                              cid = "";
                                               selected_media_body_id = '';


                                          }
                                          else{

                                            var commentreadarea = document.getElementById('comment_read_area');
                                            commentreadarea.innerHTML = response['data'] + commentreadarea.innerHTML;
                                         
                                          }
                                          window.location.reload();
                                          
                                      }
                                      else if(response['status']=='201')
                                      {
                                          alert('post unsuccessful');
                                      }
                                      else
                                      {
                                          if(response['status']=='300')
                                          {
                                              if(response['data'] == 'loginerror')
                                              {
                                                  alert("please login first");
                                              }

  
                                          }
                                      }
                                  }
  
  
                              }
                              conn.open("POST", 'restapis/commentapi.php?action=postcomment', 1);
                              conn.send(formdata);
  
                               comment_box.setData('');
  
                          }

                          function aaa()
                          {
                              alert('it\'s working');
                          }
    
    function withdrawreplies(t)
    {    
        if(t.dataset.action == 'withdraw')
        {
            t.innerHTML = "hide all replies";
            t.dataset.action = "hide";
        
    
        var media_body = document.getElementById(t.dataset.no);
        var media_body_count = document.getElementsByClassName('media-body').length ;

        var child_media  = media_body.getElementsByClassName('media');
        for(var i =0 ; i<child_media.length; i++)
        {
            child_media[i].style.display = 'none';
        } 

       
        var formdata = new FormData();
        formdata.append("commentid", t.dataset.commentid);
        formdata.append("media_body_count", media_body_count );
        var con = new XMLHttpRequest();
        con.onreadystatechange = function()
                                  {
                                     if(con.readyState == 4)
                                     {   
                                         var response = JSON.parse(con.responseText);
                                        
                                         if(response['status'] == '200')
                                         {
                                            for(var i= 0; i< response['data'].length; i++)
                                            {
                                                media_body.innerHTML = media_body.innerHTML + response['data'][i];
                                            }
                                         }
                                         else
                                         {
                                             alert(response['data']);
                                         }
                                     }
                                  }
        con.open("POST", "restapis/commentapi.php?action=getreplies", 1);
        con.send(formdata);

        }

        else
        {
            t.innerHTML = "view all replies";
            t.dataset.action = 'withdraw';

            var media_body = document.getElementById(t.dataset.no);
        var media_body_count = document.getElementsByClassName('media-body').length ;

        var child_media  = media_body.getElementsByClassName('media');
        for(var i =0 ; i<child_media.length; i++)
        {
            child_media[i].style.display = 'none';
        } 


        }

    }

    function comment_reaction(t)
{
    var media_body = document.getElementById(t.dataset.no);
    var action_to_perform  = t.dataset.action ;
    
  
    var formdata = new FormData();
    formdata.append('comment_id', media_body.dataset.commentid);
    formdata.append('action_to_perform', action_to_perform);
    var conn  = new XMLHttpRequest();
    conn.onreadystatechange = function()
    {    
        if(conn.readyState == 4)
        {   
           var response = JSON.parse(conn.responseText);
           if(response['status'] == 200)
           {   /* one by one visit all li in the reaction ul and then check their actions if and execute command according to that */
               var parent_ul  = t.parentNode;
               var first_child = parent_ul.firstElementChild;
               var child = first_child;
               while(child)
               {     
                   if(child.matches('li'))
                   {  /* if child.dataset.action is upvote then only upvote if will execute */
                        if(child.dataset.action  == 'upvote')
                      {var p = child.getElementsByTagName('p')[0];
                       p .innerText= parseInt(p.innerText) + response['upvote'];
                         if(response['upvote'] == 1)
                         {
                            child.firstElementChild.style.color= 'green';
                         }
                         else if(response['upvote']== -1)
                         { /*if downvote = -1 that means it was already down vote but now it has become upvote so we change the color */
                             child.firstElementChild.style.color = 'black';
                         }
                         else
                         {

                         }
                        

                         
                         
                      }
                      if(child.dataset.action == 'downvote')
                      { var p = child.getElementsByTagName('p')[0];
                       p .innerText= parseInt(p.innerText) + response['downvote'];
                       if(response['downvote'] == 1 ){
                        child.firstElementChild.style.color= 'orange';
                       }
                       else if(response['downvote'] == -1 )
                       {
                           child.firstElementChild.style.color = 'black';

                       }
                       else
                       {

                       }

                        
                      }
                      if(child.dataset.action == 'report')
                      {var p = child.getElementsByTagName('p')[0];
                       p .innerText= parseInt(p.innerText) + response['report'];

                         if(response['report'] == 1){
                            child.firstElementChild.style.color= 'red';
                         }
                         else if(response['report'] == -1)
                         {
                             child.firstElementChild.style.color = 'black';
                         }
                         else
                         {

                         }
                         
                      }
                       
                   }

                   child = child.nextElementSibling;

               }


           }
        }
    }
    conn.open('POST', 'restapis/commentapi.php?action=reaction' , 1);
    conn.send(formdata);
}
  
function post_reaction(t)
{
    var reactionsboxul = document.getElementById('post-reaction');
    var action_to_perform = t.dataset.action;
    var post_id = reactionsboxul.dataset.postid;

    var formdata = new FormData();
    formdata.append("post_id", post_id);
    formdata.append("action_to_perform", action_to_perform);
    
    var con = new XMLHttpRequest();
    con.onreadystatechange = function(){

        if(con.readyState == 4)
        {      
            
             var response = JSON.parse(con.responseText);
            if(response['status'] == 200)
             {

               var first_child = reactionsboxul.firstElementChild;
               var child = first_child;
               while(child)
               {     

                   if(child.matches('li'))
                   {  /* if child.dataset.action is upvote then only upvote if will execute */
                     
                        if(child.dataset.action  == 'upvote')
                      {  var p = child.getElementsByTagName('p')[0];
                       p .innerText= parseInt(p.innerText) + response['upvote'];
                         if(response['upvote'] == 1)
                         {
                            child.firstElementChild.style.color= 'green';
                         }
                         else if(response['upvote']== -1)
                         { /*if downvote = -1 that means it was already down vote but now it has become upvote so we change the color */
                             child.firstElementChild.style.color = 'black';
                         }
                         else
                         {

                         }
                         
                         
                      }
                      if(child.dataset.action == 'downvote')
                      { var p = child.getElementsByTagName('p')[0];
                       p .innerText= parseInt(p.innerText) + response['downvote'];
                       if(response['downvote'] == 1 ){
                        child.firstElementChild.style.color= 'orange';
                       }
                       else if(response['downvote'] == -1 )
                       {
                           child.firstElementChild.style.color = 'black';

                       }
                       else
                       {

                       }

                        
                      }
                     if(child.dataset.action == 'report')
                      {var p = child.getElementsByTagName('p')[0];
                       p .innerText= parseInt(p.innerText) + response['report'];

                         if(response['report'] == 1){
                            child.firstElementChild.style.color= 'red';
                         }
                         else if(response['report'] == -1)
                         {
                             child.firstElementChild.style.color = 'black';
                         }
                         else
                         {

                         }
                         
                      }
                      
                       
                   }

                   child = child.nextElementSibling;

               }


           }
        }
    }

    con.open("POST", "restapis/postapi.php?action=reaction", 1)
    con.send(formdata);


}
function delete_comment(t)
{
    var formdata = new FormData();
    formdata.append('comment_id', t.dataset.commentid);
    var conn = new XMLHttpRequest();
    conn.onreadystatechange = function(){
                                  
                                  if(conn.readyState == 4)
                                  {   
                                      var response = JSON.parse(conn.responseText);
                                      
                                      if(response['status']=='200')
                                      {
                                          ;

                                       
                                          window.location.reload();
                                          
                                      }
                                      else if(response['status']=='201')
                                      {
                                          alert('delete unsuccessful');
                                      }
                                      else
                                      {
                                          if(response['status']=='300')
                                          {
                                              if(response['data'] == 'loginerror')
                                              {
                                                  alert("please login first");
                                              }

  
                                          }
                                      }
                                  }
  
  
                              }
                              conn.open("POST", 'restapis/commentapi.php?action=deletecomment', 1);
                              conn.send(formdata);
}
</script>

<?php include "headerfooter/footer.php"?>
</body>
</html>