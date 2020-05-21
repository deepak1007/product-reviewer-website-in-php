
<style>
.border-config{border:none;}

@media screen and (min-width:765px)
{
.max-hide { display:none;}
}

ul { height:42px !important;}

ul li , ul li a{ height:100% !important;}

.dark-hover li a:hover
{
    background:black;
}
.color-white{color:white;}

@media screen and (max-width:900px)
{
    .min-hide { width:700px; display:inline-block;}
}
@media screen and (max-width:889px)
{
.min-hide { width:0px; display:inline-block;}
.hide { display:none !important;}
}

@media screen and (max-width:765px)
{
.min-hide { width:20vw !important; display:inline-block;}
.hide-profile { display:none !important;}
}

@media screen and (max-width:350px)
{
.min-hide { width:15vw !important; display:inline-block;}
}

</style>





    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand pl-xl-4 text-warning " href="index.php">ReviewIt</a>
         
        <div class='min-hide'></div>

        <ul class='nav max-hide  dark-hover' >  <li class="nav-item dropdown">
            <button type='button' class='btn btn-dark dropdown-toggle' data-toggle='dropdown'><span><img class="" style='width:45px;' src= <?php echo isset($_SESSION['propic'])?$_SESSION['propic']:""; ?> ></span> </button>
            <div class="dropdown-menu dropdown-menu-right bg-dark">
             <a class="dropdown-item text-white" href="profile.php"><i class="fa fa-user color-white" aria-hidden="true"></i>&nbsp;&nbsp;profile</a>
                  <a class="dropdown-item text-white" href="poster.php"><i class="fa fa-pencil color-white" aria-hidden="true"></i>&nbsp;&nbsp;write</a>
                  <a class="dropdown-item text-white" href="chatbox.php"><i class="fa fa-comment color-white" aria-hidden="true"></i>&nbsp;&nbsp;Messages</a>
                  <a class="dropdown-item text-white" href="logout.php"><i class="fa fa-sign-out color-white" aria-hidden="true"></i>&nbsp;&nbsp;logout</a>
                 
               </div>
        </li></ul>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class='col-xl-3 col-md-1'></div>
        
        
        
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          
          <div class='col-xl-2 col-md-1 col-sm-0 hide'>
                 </div>
       <!--search bar here -->
          <form class="form-inline col p-0" action="search_redirect.php" method='post'>
            <input class="form-control mr-sm-2 " name='topic' type="text" style='width:80%' placeholder="Search">
            <button class="btn btn-warning" type="submit" ><i class='fa fa-search p-1' aria-hidden='true'></i> </button>
          </form>

          <ul class="navbar-nav dark-hover">
            <li class="nav-item dropdown pr-4">
                <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#">Categories</a>
                <div class="dropdown-menu bg-dark border-config">
                  <?php 
                  $smt_cat = $con->prepare("select * from category");
                  $smt_cat->execute();
                  while($category_row = $smt_cat->fetch())
                  {
                   ?>
                   <a class="dropdown-item text-white" href="search.php?category=<?php echo $category_row['serial_no']?>&&page=1" ><?php echo $category_row['cat_name']; ?></a>
                   <?php
                  }
                  ?>
                 
                 
                </div>
            </li>
            <li class="nav-item pr-2">
              <a class="nav-link text-white"  <?php  echo isset($_SESSION['login'])?"style='display:none'":""; ?>  href="#" onclick='login_form_opener()'>login</a>
            </li>
           <li class="nav-item pr-2">
              <a class="nav-link text-white"  <?php  echo isset($_SESSION['login']) ?"style='display:none'":""; ?>   href="#" onclick='signup_form_opener()'>signup</a>
            </li>  
            
            <li class="nav-item dropdown hide-profile"  <?php  echo isset($_SESSION['login'])?"":"style=display:none"; ?> >
                <button type='button' class='btn btn-dark dropdown-toggle' data-toggle='dropdown'><span><img class="" style='width:45px;' src=<?php echo $_SESSION['propic']; ?>></span> </button>
                <div class="dropdown-menu dropdown-menu-right bg-dark">

                  <a class="dropdown-item text-white" href="profile.php"><i class="fa fa-user color-white" aria-hidden="true"></i>&nbsp;&nbsp;profile</a>
                  <a class="dropdown-item text-white" href="poster.php"><i class="fa fa-pencil color-white" aria-hidden="true"></i>&nbsp;&nbsp;write</a>
                  <a class="dropdown-item text-white" href="chatbox.php"><i class="fa fa-comment color-white" aria-hidden="true"></i>&nbsp;&nbsp;Messages</a>
                  <a class="dropdown-item text-white" href="logout.php"><i class="fa fa-sign-out color-white" aria-hidden="true"></i>&nbsp;&nbsp;logout</a>
                  
                 
                </div>
            </li>
           

          </ul>
          </div> 
      </nav>


