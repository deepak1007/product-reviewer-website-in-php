<?php

session_start();
include_once "config/dbconnect.php";




function filter($querystring)
{
    $querystringfilterarray = explode(' ', $querystring);
    $filters = array("in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then", "is");
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
$rows_to_display = 5;

if(isset($_GET['topic']))
{

$topic_string  = trim($_GET['topic']);
$topic_string_keywords = filter($topic_string);

$where_constraints = '';
$x = 0;
foreach($topic_string_keywords as $value)
{
    if($x==0)
    {
        $where_constraints.="post_heading like '%$value%'";
    }
    else
    {
        $where_constraints.=" and post_heading like '%$value%'";
    }
    $x++;
}
}
else
{   if(isset($_GET['category']))
    {
        $where_constraints = "category=".$_GET['category'];
    }
    else
    {
        $where_constraints = 1;
    }
    
  
}

try {

    if(isset($_GET['page']))
    {
        $query = "select count(*) from posts where " . $where_constraints;
        
        $smt = $con->prepare($query);
        $smt->execute();
        $total_rows = $smt->fetch();
        
        $total_pages = ceil(intval($total_rows['count(*)']  / $rows_to_display));
      
    }
    else
    {
        header('location:index.php');
    }
    $page_no = $_GET['page'];
    $offset = ($page_no -1) * $rows_to_display ;
    if($page_no== $total_pages)
    {
       $rows_to_display = 10000;
    }
    
    $query = "select * from posts where " . $where_constraints . " order by upvotes desc, downvotes asc limit $offset , $rows_to_display";
    $smt = $con->prepare($query);
    $smt->execute();





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src='app.js'></script>
    <link rel='stylesheet' href='style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>
    <title>Document</title>
</head>
<body>
    <?php include "headerfooter/header.php";
    include "login.php" ;
    include "signup.php";
    
    
    ?>

    
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <h2>
                    Search Results: <?php echo $total_rows['count(*)']; ?>
                </h2>
                <hr/>
            </div>
            <!-- article type the topics and the descriptions -->
            <?php
           
              while($row = $smt->fetch())
              {
                  $smt2 = $con->prepare("select profile_picture, user_public_id from login where user_id=?");
                  $smt2->execute(array($row['user_id']));
                  $user_details_row = $smt2->fetch();
                  $profile_picture = $user_details_row['profile_picture']==''?'images/question.jpg' : $user_details_row['profile_picture'];

              
          ?>
            <article class="col-12 col-xl-10 offset-xl-1 mt-3">
                <div class="row">
                    <div class="col-2 col-sm-1"><!-- for profile pic-->
                        <div class="row">
                            <div class="col-12"> 
                                <img src="<?php echo $profile_picture
                                ; ?>" style='width:100%' alt=""> <!-- profile pic of the user -->
                            </div>
                            
                        </div>
                    </div>
                    <!-- for tiltle and rest of the content -->
                    <div class="col-9 col-sm-11">
                        <div class="row">
                            <div class="col-12 ml-3">
                                <!-- for title -->
                                <h5><!--title --> <?php echo $row['post_heading']; ?>  </h5>
                                <h6><small> <a href="profile.php?user=<?php echo $user_details_row['user_public_id']?>" style='text-decoration:none;' title='go to profile'><?php echo $row['user_id']; ?></a> </small></h6>
                            </div>
                        </div>
                    </div>

                    <!-- for the content -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-1">
                                   <div class="row">
                                   <div class="col-2 col-sm-12 offset-2 offset-sm-0">
                                   <i class='fa fa-arrow-up'></i> <?php echo $row['upvotes'] ?> <!-- like button add php-->
                                     </div>
                                     <div class="col-2 col-sm-12">
                                     <i class='fa fa-arrow-down'></i> <?php echo $row['downvotes'] ?> <!-- dislike button add php-->
                                    </div>

                                    <div class="col-2 col-sm-12">
                                    <i class="fa fa-flag" aria-hidden="true"></i> <?php echo $row['reports'] ?> <!-- dislike button add php-->
                                    </div>
                                 
                                   </div>
                            </div>
                            <div class="col-11 col-sm-10 ml-3 mt-1">
                                <p class='text-justify'><?php echo  substr(strip_tags($row['post_content']), 0, 300)."..."; ?>
                                 <a href='postread.php?post_id=<?php echo $row['post_id']; ?>' style='text-decoration:none' title='go to the post'>Read More</a>
            </p>
            <div class="date-time-row col-8 ">
                        <div class="row">
                            <div class="viewbox">
                                 <h5><small><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row['views']; ?></small></h5>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='datebox'>
                                <h5><small><i class='fa fa-calendar-o' aria-hidden="true"></i>&nbsp;<?php echo date('d-M-Y', $row['post_date']);?></small></h5>
                            </div>
                        </div>

                    </div>
        
        
        </div>
                        </div>
                    </div>
                   
                   
                </div>
                <hr/>
</article>
<?php
}

?>




</div>

    <nav class='row'>
  
    <div class='mx-auto w-20 mb-3'>
    <ul class="pagination">
   
  <?php 
  if(isset($_GET['topic']))
  {
    $redirect_query = 'topic='. $_GET['topic'] . '&&';
  }
  else
  {
  $redirect_query = '';
  }

  if($page_no == 1)
  {
     $disabled_flag_previous = "disabled";
  }
  else
  {
      $disabled_flag_previous='';
  }

  if($page_no > $total_pages)
  {
      $disabled_flag_next = 'disabled';
     
  }
  else
  {
      $disabled_flag_next ='';
   
  }

?>
 <li class="page-item <?php echo $disabled_flag_previous; ?>"><a class="page-link" href="<?php echo "?".$redirect_query."page=".($page_no-1); ?>">Previous</a></li>

 <?php
  for($i=$page_no-1; $i <=$page_no + 2; $i++ )
 {     if($i == 0 )
        {
            $i = 1;
        }
        if($i== $total_pages + 1)
        {
        break;
        }
        if($i == $page_no)
        {
            $active = "active";
        }
        else
        {
            $active = "";
        }
 ?>


  <li class="page-item <?php echo $active; ?>"><a class="page-link" href="<?php echo "?".$redirect_query."page=".$i; ?>"><?php echo $i ?></a></li>
  
  <?php
}
?>

  <li class="page-item <?php echo $disabled_flag_next; ?>"><a class="page-link" href="<?php echo "?".$redirect_query."page=".($page_no+1); ?>">Next</a></li>
 
        </ul>
    </div>
     
    </nav>



    <?php
            }catch(PDOException $e)
            {
                echo $e->getMessage() ;
            }
            ?>


</div>

  
<footer class='container-fluid bg-dark' style='position:sticky; top:100'>

<div class="row">
<div class='col-12'>
    <h3 class='text-white' style='text-align:center'><small><a href='#' style='color:white'>about us</a> . <a href='#' style='color:white'>contact us</a></small></h3>  
    </div>
    
   
  
</div>


</div>

</footer>
    
</body>
</html>