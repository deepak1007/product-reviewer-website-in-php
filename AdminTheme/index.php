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

          .modal-container {
             width:100vw;
             height:100vh;
             position:fixed;
             top:0px ;
             left:0px;
          z-index:9999;
          display:none;
         

          }
          .modal-background {
             display:block;
             width:100vw;
             height:100vh;
             background:rgba(0,0,0,0.5);
          }
          .modal{
                display:inline-block;
                position:absolute;
                top:10px;
                left:50%;
                transform:translateX(-50%);
               height:60vh;
               
                background:white;

          }

          .modal div{
            position:relative;
            margin-top:20px;
          }
          .modal div form{

            position:absolute;
            left:50%;
            transform:translateX(-50%);

            
          }
          .modal div form input{
             margin-bottom:10px;
          }
          .modal div form button {
             position:relative;
           
            
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
                     <a href="logout.php" > Logout </a>
                  </li>
               </ul>
            </div>
         </nav>
      </aside>
      <div id="right-panel" class="right-panel">
         <header id="header" class="header">
            <div class="top-left">
               <div class="navbar-header">
                  <!--<a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
                  <a class="navbar-brand hidden" href="index.html"><img src="images/logo2.png" alt="Logo"></a>-->

                   <a class='navbar-brand' href='index.html'> ReviewIt </a>
                  <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
               </div>
            </div>
            <div class="top-right">
               <div class="header-menu">
                  <div class="user-area dropdown float-right">
                     <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome Admin</a>
                     <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="#"><i class="fa fa-power-off"></i>Logout</a>
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
                           <h4 class="box-title">Users </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th class="avatar">Avatar</th>
                                       <th>ID</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
                                       <th>Password</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>

                                 <?php
                                 $limit = 5; 
                                  $smt = $con->prepare("select count(*) from login order by user_name");
                                  $smt->execute();
                                  $total_pages = ceil($smt->fetch()['count(*)']/$limit);

                                  $smt->execute();
                                   $page  =  isset($_GET['page'])?$_GET['page'] : 1;
                                   
                                   $offset = ($page-1) * $limit;
                                   $smt = $con->prepare("select * from login order by user_name ASC limit $offset, $limit");
                                   $smt->execute();
                                   $count =  1;
                                   while($row = $smt->fetch())
                                   {  $user_id = $row['user_id'];
                                      $name = $row['user_name'];
                                      $email= $row['email'];
                                      $phone = $row['phone_no'];
                                      $password = $row['password'];
                                      $propic = ($row['profile_picture']=='')?'images/question.jpg':$row['profile_picture'];
                                      $user_public_id = $row['user_public_id'];
                                            
                                   ?>


                                    <tr>
                                       <td class="serial"><?php echo $count; ?></td>
                                       <td class="avatar">
                                          <div class="round-img">
                                             <a href="#"><img class="" src="../<?php echo $propic;?>" alt=""></a>
                                          </div>
                                       </td>
                                       <td> <a href='../profile.php?user=<?php echo $user_public_id;?>'><?php echo $user_id; ?> </a> </td>
                                       <td> <span class="name"><?php echo $name ?></span> </td>
                                       <td> <span class="product"><?php echo $email ;?></span> </td>
                                       <td><span class="product"><?php echo $phone ; ?></span></td>
                                       <td><span class="product"><?php echo $password ; ?></span></td>
                                       <td>
                                          <span class="badge badge-complete" style='cursor:pointer'  data-id='<?php echo $user_id ?>' onclick='fetch(this)'>Edit</span>
                                          <span class="badge badge-complete badge-delete" data-id='<?php echo $user_id;?>' style='cursor:pointer'  onclick='deletedata(this)'>Delete</span>
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
                                   if($page< $total_pages)
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
      <div class="container-fluid modal-container">
      <div class="row">
      <div class="modal-background col-12">

          </div>
          <div class="modal col-10 col-md-4">
            
            <h2 class='text-center'>Edit User</h2>
            <hr>
            <div>
            <form action="" method='POST' id='modal-form'>
              
       
           <!--   User ID : <br><input type="text" name="username" id="username"><br>-->
             User Email : <br> <input type="text" name="email" id='email'><br>
            User Password : <br><input type='password' name="password" id='password'><br>
            <input type="submit" name='edit-submit' id='edit-submit' style='visibility:hidden;height:0px; width:0px;'>
             
           <button type='button' onclick='confirmit(this)' data-id='' id='confirm-but' value='change' class='btn btn-primary mr-4'> change </button>
           <button type='button' onclick='closemodal()' value='change' class='btn btn-success'> Close </button>
 
             </form>
            </div>
           
            </div>



          </div>
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
             window.location.href = "deleteuser.php?user_id=" + t.dataset.id;
         }
         else
         {

         }
    }    

    function confirmit(t)
    {
       var con = confirm("do you really want to change it?");
       if(con)
       {  
          document.getElementById('modal-form').setAttribute("action" ,  "edituser.php?user_id=" + t.dataset.id);

          document.getElementById('edit-submit').click();
       }
    }  



          function closemodal()
          {
             document.getElementsByClassName('modal-container')[0].style.display = 'none';
          }



        function fetch(t)
        {
         
          var con = new XMLHttpRequest();
      
     

          con.onreadystatechange = function(){
             if(con.readyState == 4)
             {
                
                var response = JSON.parse(con.responseText);
                if(response['status'] == 200)
                {
                   // document.getElementById('username').value = response['data']['user_id'];
                    document.getElementById('password').value = response['data']['password'];
                    document.getElementById('email').value = response['data']['email'];
                    document.getElementById('confirm-but').dataset.id =response['data']['user_id']; 
                }
                else
          {

          }

            document.getElementsByClassName('modal-container')[0].style.display = 'block';

             }


          }

          con.open("POST", 'fetchuser.php?user_id=' + t.dataset.id , 1)
          con.send();
          

        }  
    </script>
   </body>
</html>