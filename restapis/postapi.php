<?php
session_start();
include "../config/dbconnect.php";
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action']=='makepost')
{
    if(isset($_POST['title']) && isset($_POST['content']))
    {
          $user_id = $_SESSION['user_id'];
          $post_id = $user_id . time(). substr($_POST['title'],0,20);
          $post_heading = $_POST['title'];
          $post_content = $_POST['content'];
          $post_category = $_POST['category'];
          $post_date = time();
          $post_time = time();
  try{
       
    $query = "insert into posts values(0, :user_id, :post_id, :post_heading, :post_content,:post_category, :post_date, :post_time, 0, 0, 0, 0, 0, 0);";
        
         $smt = $con->prepare($query);
         $field_values = array("user_id"=>$user_id, "post_id"=>$post_id, "post_heading"=>$post_heading, "post_content"=>$post_content, "post_category"=>$post_category, "post_date"=>$post_date, "post_time"=>$post_time);
         
         if($smt->execute($field_values))
         {
             $result = array("status"=>'200', "data"=>$post_id);
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
         


    }
}
elseif($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action'] == 'reaction')
{
    if(isset($_POST['action_to_perform']) && isset($_POST['post_id']))
    {
        $response = array();
        $post_id  = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $presence_check_query = "select count(*), upvote, downvote,report from reaction where user_id=? and post_id=? and comment_id=''";
        $smt = $con->prepare($presence_check_query);
        $smt->execute(array($user_id, $post_id));
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
           { $query = "update posts set upvotes = upvotes  + 1 , downvotes= downvotes - ".$row['downvote']."  where post_id=?";
            $query_for_reaction = "update reaction set upvote= 1 , downvote = 0 where user_id=? and post_id=?";
              $upvote = 1;
              if($row['downvote']>0)
              {
                  $downvote = -1;
              }
           }
           else
           {
            $query = "update posts set upvotes = upvotes  -  1 where post_id=?";
            $query_for_reaction = "update reaction set upvote= 0  where user_id=? and post_id=?";
            $upvote =  -1 ;
           }

        }
        elseif($_POST['action_to_perform'] == 'downvote')
        { if($row['downvote'] == 0)
            {
            $query = "update posts set downvotes = downvotes + 1, upvotes= upvotes - ". $row['upvote']. " where post_id=?";
            $query_for_reaction = "update reaction set upvote= 0 , downvote = 1 where user_id=? and post_id=?";
            $downvote = 1;
            
             if($row['upvote'] == 1)
             {  
                 $upvote = -1;
             }
            }
             else
             {
              $query = "update posts set downvotes = downvotes - 1 where post_id=?";
              $query_for_reaction = "update reaction set downvote =0 where user_id=? and post_id=?";
              $downvote =  -1 ;
             }
        }
        elseif($_POST['action_to_perform'] == 'report')
        {   if($row['report'] == 0)
            {$query = "update posts set reports = reports + 1 where post_id=?";
            $query_for_reaction = "update reaction set report=1 where user_id=? and post_id=?";
            $report = 1;
            }
            else
            {
                $query = "update posts set reports = reports -1  where post_id=?";
            $query_for_reaction = "update reaction set report=0 where user_id=? and post_id=?";
            $report = -1;

            }
        }
        else
        {
            echo json_encode(array("status"=>201, "data"=>"nothing"));
             die();
        } 

        $smt = $con->prepare($query);
        if($smt->execute(array($post_id)))
        {
            $smt = $con->prepare($query_for_reaction);
            if($smt->execute(array($user_id, $post_id)))
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
            $query = "update posts set upvotes = upvotes  + 1 where post_id=?";
            $query_for_reaction = "insert into reaction values(NULL, :user_id, :post_id , '', 1, 0, 0 , 1)";
            $upvote = 1;
            if($row['downvote']>0)
              {
                  $downvote = -1;
              }
        }
        elseif($_POST['action_to_perform'] == 'downvote')
        {
            $query = "update posts set downvotes = downvotes  + 1 where post_id=?";
            $query_for_reaction = "insert into reaction values(NULL, :user_id, :post_id , '', 0, 1, 0, 1)";
              $downvote = 1;
              if($row['upvote'] > 0)
              {
                  $upvote = -1;
              }
        }
        elseif($_POST['action_to_perform'] == 'report')
        {
            $query = "update posts set reports = reports + 1 where post_id=?";
            $query_for_reaction = "insert into reaction values(NULL, :user_id, :post_id,'', 0, 0, 1, 1)";
            $report = 1;
            
        }
        else
        {
            echo json_encode(array("status"=>201, "data"=>"nothing"));
             die();
        } 


        $smt = $con->prepare($query);
        if($smt->execute(array($post_id)))
        {
            $smt = $con->prepare($query_for_reaction);
            if($smt->execute(array('user_id'=> $user_id, 'post_id'=> $post_id)))
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
else
{
    echo json_encode(array("status" => 200, "data"=> ""));
}