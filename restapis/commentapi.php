<?php

session_start();
include "../config/dbconnect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action'] == 'getreplies')
    {
        if(isset($_POST['commentid']) && isset($_POST['media_body_count']))
        {
            try{
                $query = "select * from comments where replyto=?";
                $smt = $con->prepare($query);
                $smt->setFetchMode(PDO::FETCH_ASSOC);
                $smt->execute(array($_POST['commentid']));
                $response = array();
                $i = $_POST['media_body_count'] ;
                while($row=$smt->fetch())
                {   $query = "select * from login where user_id=?";
                    $innersmt = $con->prepare($query);
                    $innersmt->setFetchMode(PDO::FETCH_ASSOC);
                    $innersmt->execute(array($row['user_id']));
                    $innerrow = $innersmt->fetch();

                    $query = "select count(*), upvote, downvote,report from reaction where user_id=? and comment_id=?";
                    $innersmt = $con->prepare($query);
                    $innersmt->execute(array($row['user_id'], $row['comment_id']));
                    $innerrow2 = $innersmt->fetch();
                    $upvote_flag= $downvote_flag = $report_flag =0 ;
                    if($innerrow2['count(*)'] >0 )
                    {
                      $upvote_flag = $innerrow2['upvote'] ;
                      $downvote_flag = $innerrow2['downvote'];
                      $report_flag = $innerrow2['report'];
                    }
    
                   $response[] = "<div class=\"media p-3\">
                   <img src=\'".$innerrow['profile_picture']."\'  alt=\"John Doe\" class=\"mr-3 mt-3 rounded-circle\" style=\"width:60px;\">
                  <div class=\"media-body\" id='".$i."' data-commentid='". $row['comment_id']. "' data-type='comment'>
                  <h4>". $row['user_id'] ." <small><i>Posted on". $row['comment_date'] . "  </i></small></h4>
                 <p>". $row['content'] ."</p>
                 <ul class='list-inline'>
                 <li class='list-inline-item' onclick='comment_reaction(this)' data-action='upvote' data-no='".$i."'><!--<i class='fa fa-arrow-up' aria-hidden='true'></i>--> <i class='yo'" . (($upvote_flag)?"style='color:green'":"style='color:black'") .">f</i>&nbsp;<p style='display:inline-block'>".$row['upvotes'] ."</p></li>

                 <li class='list-inline-item' onclick='comment_reaction(this)' data-action='downvote' data-no='". $i ."' ><i class='yo'". (($downvote_flag)?"style='color:orange'":"style='color:black'") .">f</i>&nbsp;<p  style='display:inline-block'>".$row['downvotes'] . "</p></li>

                 <li class='list-inline-item' onclick='comment_reaction(this)' data-action='report' data-no='".$i."'><i class='yo'" .(($report_flag)?"style='color:red'":"style='color:black'"). ">f</i>&nbsp;<p  style='display:inline-block'>". $row['reports']."</p></li>


                     <li class='list-inline-item repliesbutton' onclick='changeid(this)' data-commentid='".$row['comment_id']."' data-no='".$i ."'> reply </li>
                     </ul>
                     <ul class='list-inline'>

                     <li class='list-inline-item' onclick='withdrawreplies(this)' data-commentid='".$row['comment_id']. "' data-no='". $i ."' data-action='withdraw'> view all replies </li>
                     
                    </ul>
                  </div>
                 </div>";
               $i++;
                }
    
                $result = array();
                $result['status'] = '200';
                $result['data'] = $response ;
                echo json_encode($result);
    
    
    
            }
            catch(PDOException $e)
            {
                echo json_encode(array('status'=>'201', 'data'=>$e->getMessage()));
    
            }
        }
    }
    
    elseif($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action'] == 'postcomment')
    {
        if(isset($_POST['comment_content']) && isset($_POST['post_id']) && isset($_POST['replyto']) && isset($_POST['media_body_count']))
        {
              $user_id = isset($_SESSION['user_id'])? $_SESSION['user_id'] : die(json_encode(array("status"=>"300", "data"=>"loginerror")));

              $post_id = trim($_POST['post_id']);
              $comment_id = $user_id . time(). $_POST['post_id'].rand();
              $comment_content = trim($_POST['comment_content']);
              $replyto = htmlspecialchars($_POST['replyto']);
              $comment_date = time();
              $comment_time = time();
      try{
           
        $query = "insert into comments values(0, :post_id,:comment_id,:user_id, :comment_content, :comment_date, :comment_time, 0, 0, 0, :replyto);";
            
             $smt = $con->prepare($query);
             $field_values = array("user_id"=>$user_id, "post_id"=>$post_id, "comment_id"=>$comment_id, "comment_content"=>$comment_content, "comment_date"=>$comment_date, "comment_time"=>$comment_time , "replyto"=>$replyto);
             $smt->setFetchMode(PDO::FETCH_ASSOC);
             $i = $_POST['media_body_count'];
             if($smt->execute($field_values))
             {     
              
               $response = "<div class=\"media p-3\">
                <img src=\'". $_SESSION['propic']."\'  alt=\"John Doe\" class=\"mr-3 mt-3 rounded-circle\" style=\"width:60px;\">
               <div class=\"media-body\" id='".$i."' data-commentid='". $comment_id. "' data-type='comment'>
               <h4>". $user_id ." <small><i>Posted on ". $comment_date . "  </i></small></h4>
              <p>". $comment_content ."</p>
              <ul class='list-inline'>
              <li class='list-inline-item' onclick='comment_reaction(this)' data-action='upvote' data-no='".$i."'><!--<i class='fa fa-arrow-up' aria-hidden='true'></i>--> <i class='yo'>f</i>&nbsp;<p style='display:inline-block'>0</p></li>

              <li class='list-inline-item' onclick='comment_reaction(this)' data-action='downvote' data-no='". $i ."' ><i class='yo'>f</i>&nbsp;<p  style='display:inline-block'>0</p></li>

              <li class='list-inline-item' onclick='comment_reaction(this)' data-action='report' data-no='".$i."'><i class='yo'>f</i>&nbsp;<p  style='display:inline-block'>0</p></li>


                  <li class='list-inline-item repliesbutton' onclick='changeid(this)' data-commentid='".$comment_id. "' data-no='".$i ."'> reply </li>
                  </ul>
                  <ul class='list-inline'>

                  <li class='list-inline-item' onclick='withdrawreplies(this)' data-commentid='".$comment_id. "' data-no='". $i ."' data-action='withdraw'> view all replies </li>
                  
                 </ul>
               </div>
              </div>";
                    
                
           
    
            
                 $result = array("status"=>'200' ,"data" => $response);
                 echo json_encode($result);
    
             }
             else
             {
                 $result = array("status" => '201');
                 echo json_encode($result);
    
             }
    
      }
      catch(PDOException $e)
      {
             $result = array("status"=>"300", "data"=>$e->getMessage());
             echo json_encode($result);
    
      }
      catch(Exception $e)
      {
        $result = array("status"=>"300", "data"=>$e->getMessage());
        echo json_encode($result);
      }
             
    
    
        }
    }

    elseif($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action'] == 'reaction')
    {
    try{ 
        if(isset($_POST['comment_id']) && isset($_POST['action_to_perform']))
        {   $response = array();
            $comment_id  = $_POST['comment_id'];
            $user_id = $_SESSION['user_id'];
            $presence_check_query = "select count(*), upvote, downvote,report from reaction where user_id=? and comment_id=?";
            $smt = $con->prepare($presence_check_query);
            $smt->execute(array($user_id, $comment_id));
            $row = $smt->fetch();
          
            $presence_flag = 0;
            if($row['count(*)'] > 0)
            {  
                  $presence_flag = 1;
                  $upvote = 0;
                  $downvote = 0;
                  $report  = 0;
                  
            if($_POST['action_to_perform'] == 'upvote')
            {  if($row['upvote'] == 0)
               { $query = "update comments set upvotes = upvotes  + 1 , downvotes= downvotes - ".$row['downvote']."  where comment_id=?";
                $query_for_reaction = "update reaction set upvote= 1 , downvote = 0 where user_id=? and comment_id=?";
                  $upvote = 1;
                  if($row['downvote']>0)
                  {
                      $downvote = -1;
                  }
               }
               else
               {
                $query = "update comments set upvotes = upvotes  -  1 where comment_id=?";
                $query_for_reaction = "update reaction set upvote= 0  where user_id=? and comment_id=?";
                $upvote =  -1 ;
               }

            }
            elseif($_POST['action_to_perform'] == 'downvote')
            { if($row['downvote'] == 0)
                {
                $query = "update comments set downvotes = downvotes + 1, upvotes= upvotes - ". $row['upvote']. " where comment_id=?";
                $query_for_reaction = "update reaction set upvote= 0 , downvote = 1 where user_id=? and comment_id=?";
                $downvote = 1;
                
                 if($row['upvote'] == 1)
                 {  
                     $upvote = -1;
                 }
                }
                 else
                 {
                  $query = "update comments set downvotes = downvotes - 1 where comment_id=?";
                  $query_for_reaction = "update reaction set downvote =0 where user_id=? and comment_id=?";
                  $downvote =  -1 ;
                 }
            }
            elseif($_POST['action_to_perform'] == 'report')
            {   if($row['report'] == 0)
                {$query = "update comments set reports = reports + 1 where comment_id=?";
                $query_for_reaction = "update reaction set report=1 where user_id=? and comment_id=?";
                $report = 1;
                }
                else
                {
                    $query = "update comments set reports = reports -1  where comment_id=?";
                $query_for_reaction = "update reaction set report=0 where user_id=? and comment_id=?";
                $report = -1;

                }
            }
            else
            {
                echo json_encode(array("status"=>201, "data"=>"nothing"));
                 die();
            } 

            $smt = $con->prepare($query);
            if($smt->execute(array($comment_id)))
            {
                $smt = $con->prepare($query_for_reaction);
                if($smt->execute(array($user_id, $comment_id)))
                {
                      
                      $response['status'] = 200;
                      $response['upvote'] = $upvote;
                      $response['downvote'] = $downvote;
                      $response['report'] = $report;
                      
                      echo json_encode($response);
                }
            }
            


        }
        else
        {
            $upvote =0 ;
            $downvote = 0;
            $report = 0 ;
            if($_POST['action_to_perform'] == 'upvote')
            {
                $query = "update comments set upvotes = upvotes  + 1 where comment_id=?";
                $query_for_reaction = "insert into reaction values(NULL, :user_id, '',  :comment_id, 1, 0, 0, 1)";
                $upvote = 1;
                if($row['downvote']>0)
                  {
                      $downvote = -1;
                  }
            }
            elseif($_POST['action_to_perform'] == 'downvote')
            {
                $query = "update comments set downvotes = downvotes  + 1 where comment_id=?";
                $query_for_reaction = "insert into reaction values(NULL, :user_id, '' , :comment_id, 0, 1, 0 , 1)";
                  $downvote = 1;
                  if($row['upvote'] > 0)
                  {
                      $upvote = -1;
                  }
            }
            elseif($_POST['action_to_perform'] == 'report')
            {
                $query = "update comments set reports = reports + 1 where comment_id=?";
                $query_for_reaction = "insert into reaction values(NULL, :user_id, '' , :comment_id, 0, 0, 1, 1)";
                $report = 1;
                
            }
            else
            {
                echo json_encode(array("status"=>201, "data"=>"nothing"));
                 die();
            } 


            $smt = $con->prepare($query);
            if($smt->execute(array($comment_id)))
            {
                $smt = $con->prepare($query_for_reaction);
                if($smt->execute(array('user_id'=> $user_id, 'comment_id'=> $comment_id)))
                {
                      $response = array();
                      $response['status'] = 200;
                      $response['upvote'] = $upvote;
                      $response['downvote'] = $downvote;
                      $response['report'] = $report;
                      echo json_encode($response);
                }
            }
        }

    }
    else
    {
        echo json_encode(array("status" => 201 , "data" => "something is missing"));
    }
}
catch(PDOException $e)
{
    echo json_encode(array("data"=>$e->getMessage()));
}
}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action'] == 'deletecomment')
{

    if(isset($_POST['comment_id']))
    { 
   try {

      $comment_id = $_POST['comment_id'];
        $smt = $con->prepare("delete from comments where comment_id=? and user_id=?");
        $result = $smt->execute(array($comment_id, $_SESSION['user_id']));
        if($result)
        {
            echo json_encode(array("status"=>200, "data"=>"deleted"));
        }
    }
    catch(PDOException $e)
    {
        echo json_encode(array("status"=>201, "data"=>$e->getMessage()));
    }
    }
    else
    {
        echo json_encode(array("status"=>201, "data"=>"not deleted"));
    }

}

else
{
    echo json_encode(array("data"=>"hell"));
}