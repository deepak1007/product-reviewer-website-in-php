<?php 
session_start();
include "../config/dbconnect.php";

if(!isset($_SESSION['admin']))
{ ?>

<script> window.location.href = '../index.php'
</script>
<?php
   
}
?>
<?php
if(isset($_SESSION['result']))
{
   if($_SESSION['result']==1)
   {
      echo "<script> alert('".$_SESSION['elaborate']."');</script>";
   }
   else
   {
      echo "<script> alert('".$_SESSION['elaborate']."');</script>";
   }

   unset($_SESSION['result']);

}

?>

<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Dashboard Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

      <style>
          .badge-delete {
              background: tomato;
          }
          </style>
   </head>
   <body>
      <aside id="left-panel" class="left-panel">
         <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
               <ul class="nav navbar-nav">
                  <li class="menu-title">Menu</li>
                  <li class="menu-item-has-children dropdown">
                     <a href="index.php" > Manage Users</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="manposts.php" > Manage Posts</a>
                  </li>
				  <li class="menu-item-has-children dropdown">
                     <a href="logout.php" > logout </a>
                  </li>
               </ul>
            </div>
         </nav>
      </aside>
      <div id="right-panel" class="right-panel">
         <header id="header" class="header">
            <div class="top-left">
               <div class="navbar-header">
                  <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
                  <a class="navbar-brand hidden" href="index.html"><img src="images/logo2.png" alt="Logo"></a>
                  <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
               </div>
            </div>
            <div class="top-right">
               <div class="header-menu">
                  <div class="user-area dropdown float-right">
                     <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome Admin</a>
                     <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="../index.php"><i class="fa fa-power-off"></i>Logout</a>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Posts </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th>User Id</th>
                                       <th>Post Id</th>
                                       <th>Date</th>
                                       <th>Title</th>
                                       <th>Content</th>
                                       <th>Reports</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>

                                 <?php 
                                 $limit = 10;
                                   $smt = $con->prepare("select count(*) from posts order by post_date");
                                   $smt->execute();
                                   $total_pages = ceil($smt->fetch()['count(*)']/$limit);
 
                                   $smt->execute();
                                    $page  =  isset($_GET['page'])?$_GET['page'] : 1;
                                    $limit = 10;
                                    $offset = ($page-1) * $limit;
                                   $smt = $con->prepare("select * from posts order by post_date limit $offset , $limit");
                                   $smt->execute();
                                   $count =  1;
                                   while($row = $smt->fetch())
                                   {  $user_id = $row['user_id'];
                                      $post_id = $row['post_id'];
                                      $title= substr(strip_tags($row['post_content']),0,10);
                                      $content = substr(strip_tags($row['post_content']),0,20);
                                      $date = $row['post_date'];
                                      $reports = $row['reports'];
                                            
                                   ?>


                                    <tr>
                                       <td class="serial"><?php echo $count; ?></td>
                                       <td class="avatar">
                                       <?php echo $user_id; ?>
                                       </td>
                                       <td> <a href='../postread.php?post_id=<?php echo $post_id; ?>'><?php echo substr($post_id,0,10); ?> </a></td>
                                       <td> <span class="name"><?php echo date('d-M-Y', $date); ?></span> </td>
                                       <td> <span class="product"><?php echo $title;?></span> </td>
                                       <td><span class="product"><?php echo $content ; ?></span></td>
                                       
                                       <td><span class="product"><?php echo $reports ; ?></span></td>
                                       <td>
                                         <span class="badge badge-complete badge-delete" style='cursor:pointer' data-id='<?php echo $post_id ?>' onclick='deletedata(this)'>Delete</span>
                                          
                                          
                                       </td>
                                    </tr>

                                   <?php
                                   $count++;
                                   }
                                   ?>


<tr>
                                    <?php  if($page!= 1)
                                      { 
                                       ?>
                                       <td class="serial"> <a href="?page=<?php echo $page -1;?>" class='btn btn-primary'>prev</a></td>
                                      <?php } 
                                      else
                                      {?> 
                                       <td class="serial">&nbsp; </td>
                                       <?php }
                                 ?>
                                   <td class="avatar">
                                      <div class="round-img">
                                         &nbsp;
                                      </div>
                                   </td>
                                   <td> &nbsp;</td>
                                   <td> <span class="name">&nbsp;</span> </td>
                                   <td> <span class="product">&nbsp;</span> </td>
                                   <td><span class="product">&nbsp;</span></td>
                                   <td><span class="product">&nbsp;</span></td>
                                   <td>
                                   <?php
                                   if($page < $total_pages)
                                      {?>
                                       <a href="?page=<?php echo $page+1 ?>" class='btn btn-primary'>next</a>
                                     <?php }
                                      else
                                      {?>
                                       &nbsp; 
                                      <?php
                                      }
                                   ?>
                                   </td>
                                </tr>

                                 <!--   <tr>
                                       <td class="serial">2.</td>
                                       <td class="avatar">
                                          <div class="round-img">
                                             <a href="#"><img class="rounded-circle" src="images/avatar/2.jpg" alt=""></a>
                                          </div>
                                       </td>
                                       <td> #5468 </td>
                                       <td> <span class="name">Gregory Dixon</span> </td>
                                       <td> <span class="product">iPad</span> </td>
                                       <td><span class="count">250</span></td>
                                       <td>
                                          <span class="badge badge-complete">Complete</span>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="serial">3.</td>
                                       <td class="avatar">
                                          <div class="round-img">
                                             <a href="#"><img class="rounded-circle" src="images/avatar/3.jpg" alt=""></a>
                                          </div>
                                       </td>
                                       <td> #5467 </td>
                                       <td> <span class="name">Catherine Dixon</span> </td>
                                       <td> <span class="product">SSD</span> </td>
                                       <td><span class="count">250</span></td>
                                       <td>
                                          <span class="badge badge-complete">Complete</span>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="serial">4.</td>
                                       <td class="avatar">
                                          <div class="round-img">
                                             <a href="#"><img class="rounded-circle" src="images/avatar/4.jpg" alt=""></a>
                                          </div>
                                       </td>
                                       <td> #5466 </td>
                                       <td> <span class="name">Mary Silva</span> </td>
                                       <td> <span class="product">Magic Mouse</span> </td>
                                       <td><span class="count">250</span></td>
                                       <td>
                                          <span class="badge badge-pending">Pending</span>
                                       </td>
                                    </tr>
                                    <tr class=" pb-0">
                                       <td class="serial">5.</td>
                                       <td class="avatar pb-0">
                                          <div class="round-img">
                                             <a href="#"><img class="rounded-circle" src="images/avatar/6.jpg" alt=""></a>
                                          </div>
                                       </td>
                                       <td> #5465 </td>
                                       <td> <span class="name">Johnny Stephens</span> </td>
                                       <td> <span class="product">Monitor</span> </td>
                                       <td><span class="count">250</span></td>
                                       <td>
                                          <span class="badge badge-complete">Complete</span>
                                       </td>
                                    </tr>-->
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		  </div>
         <div class="clearfix"></div>
         <footer class="site-footer">
            <div class="footer-inner bg-white">
               <div class="row">
                  <div class="col-sm-6">
                     Copyright &copy; 2018 Ela Admin
                  </div>
                  <div class="col-sm-6 text-right">
                     Designed by <a href="https://colorlib.com/">Colorlib</a>
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>

      <script>
    function deletedata(t)
    {
         var confirm_ = confirm("do you really want to delete this data?");
         if(confirm_)
         {
             window.location.href = "deleteposts.php?post_id=" + t.dataset.id;
         }
         else
         {

         }
    }      
          
    </script>

   </body>
</html>