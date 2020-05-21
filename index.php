<?php
session_start();
include "config/dbconnect.php"; 
include "restapis/cookiecontroler.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>
    <script src='app.js'></script>
    <link rel='stylesheet' href='style.css'>
    <title>Document</title>

    <style>
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
<!-- includeing header and footer also login and signup area -->
<?php

    include "headerfooter/header.php"; 
    include "login.php" ;
     include "signup.php";
?>
<!-- end -->

    <div id='bg' class='container-fluid'>
     <div id='backg'>
        <div class="row pt-md-5 pt-sm-4 pt-xl-5">
         <div class="col-xl-5 col-md-5 col-12 col-sm-7 mt-5 offset-md-1 offset-sm-1 mt-md-4 mt-sm-3">
           <div class='row heading text-monospace'>
              <div class='col-md-12 col-sm-12'> 
              <h1 class='h'>R<small> e v i e w</small></h1> </div>
              <div class='col-md-12'> 
               <h1 class='h'>A<small> s k</small></h1></div>
               <div class='col-md-12'> 
               <h1 class='h'>D<small> i s c u s s s</small></h1></div>

               <?php 
               if(!isset($_SESSION['user_id']))
               {
                  ?>
               <div class='login col-md-12 mt-md-5 mt-sm-4 mt-3'>
              
               
               <button type='button' class='btn btn-warning pl-4 pr-4' onclick='login_form_opener()'>LOGIN</button>
                  <button type='button' class='btn' onclick='signup_form_opener()'>SIGN UP</button>

               </div>
               <?php
               }
               ?>
           </div>
         </div>
        </div>
    </div>
</div>

<article class="container">
  <div class='row'>
      <div class='col-12 text-center mt-4'>
          <h1 class='h'>Our Services</h1>
          <p>The social media for products provide following services to make your product experience doubtless.</p>
      </div>
  </div>

  <div class="row pl-md-5 pl-sm-4 mt-4 pt-5">
  <div class="card ml-md-5 ml-3 mt-md-4 shadow-lg mx-auto" style="width: 18rem;">
  <img src="images/student1.jpg" class="card-img-top rounded" alt="post">
  <div class="card-body">
    <h5 class="card-title">POST</h5>
    <h6 class="card-subtitle mb-2 text-muted">Post a Review</h6>
    <p class="card-text text-justified">Bought a product online?<br>Now you can post a review, telling your experience with the product.</p>
    
  </div>
</div>
<div class="card ml-md-5 ml-3 mt-4 mx-auto" style="width: 18rem;">
  <img src="images/question.jpg" class="card-img-top rounded" alt="post">
  <div class="card-body">
    <h5 class="card-title">ASK</h5>
    <h6 class="card-subtitle mb-2 text-muted">Ask a Question</h6>
    <p class="card-text text-justified">Have some doubts about a product?<br> Now you can ask a question to the global user base about the product to clear you doubts.</p>
   
  </div>
</div>
<div class="card ml-md-5 mx-md-auto ml-3 mt-4 mx-auto" style="width: 18rem;">
  <img src="images/comment.jpg" class="card-img-top rounded" alt="post">
  <div class="card-body">
    <h5 class="card-title">COMMENT</h5>
    <h6 class="card-subtitle mb-2 text-muted">Comment to Questions</h6>
    <p class="card-text text-justified">Want to help someone?<br>Now help them by solving their problem about products.</p>
    
  </div>
</div>
  </div>

  <div class="row mb-5">

  </div>
</article>






<section class='container'>
<div class="row">
           <div class="col-12 text-center mt-5 mb-5">
                <h1 class='font-6'>
                    Reviewing your products 
                </h1>
            </div>  
            
    <div class='col-12 mt-5 mb-5 ml-md-5'>    
        <div class='row'> 
     <div class="col-12 col-md-4 col-sm-12" style='overflow:hidden'>
        <img src="images/write1.jpg" style='width:100%; height:auto;' alt="">
    </div>
    
    <div class='col-12 col-md-8 col-sm-12'>
        <div class="row">
            <div class='col-md-8 col-sm-12 col-12 offset-md-1'>
               <p class='font-1 text-justify'>You can review your purchased product in this website telling your experience to the world.
                This clears the doubt of the people who want to buy the same product.
                You are just one step away from you first post; you just have to register an account and you are done!
               </p>
            </div>
           
            <div class='col-12 col-md-12 col-sm-12'>
                 <div class="row mt-5">
                     <div class="col-sm-8 col-md-4 col-4 offset-md-1">
                         <img src="images/question.jpg" style='width:200px;' alt="">
                     </div>
                     <div class="col-12 col-sm-1 col-md-2 offset-md-1 offset-sm-1 mt-md-6">
                         <a href='poster.php' class='btn btn-success font-2 pl-4  pr-4'>GO</a>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>



<div class="container-fluid bg-dark">

<section class='container'>
<div class="row">
           <div class="col-12 text-center mt-5 mb-5">
                <h1 class='font-6 text-white'>
                   Search for reviews 
                </h1>
            </div>  
            
    <div class='col-12 mt-5 mb-5 ml-md-5'>    
        <div class='row'> 
     <div class="col-12 col-md-4 col-sm-12" style='overflow:hidden'>
        <img src="images/search1.jpg" style='width:100%; height:auto;' alt="">
    </div>
    
    <div class='col-12 col-md-8 col-sm-12'>
        <div class="row">
          
            <div class='col-md-8 col-sm-12 col-12 offset-md-1'>
               <p class='font-1 text-justify text-white'> You Can search for reviews, read other's reviews , and share your opinions.

               </p>
              
            </div>
           
            <div class='col-12 col-md-12 col-sm-12'>
                 <div class="row mt-5">
                     <div class="col-sm-8 col-md-4 col-4 offset-md-1">
                         <img src="images/question.jpg" style='width:200px;' alt="">
                     </div>
                     <div class="col-12 col-sm-1 col-md-2 offset-md-1 offset-sm-1 mt-md-6">
                         <a href='search.php' class='btn btn-success font-2 pl-4 pr-4'>GO</a>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
</div>




<section class='container'>
<div class="row">
           <div class="col-12 text-center mt-5 mb-5">
                <h1 class='font-6'>
                    Chat with other users 
                </h1>
            </div>  
            
    <div class='col-12 mt-5 mb-5 ml-md-5'>    
        <div class='row'> 
     <div class="col-12 col-md-4 col-sm-12" style='overflow:hidden'>
        <img src="images/chat1.jpg" style='width:100%; height:auto;' alt="">
    </div>
    
    <div class='col-12 col-md-8 col-sm-12'>
        <div class="row">
          
            <div class='col-md-8 col-sm-12 col-12 offset-md-1'>
               <p class='font-1 text-justify'>you can have 1-to-1 chat with other user of the website.

               </p>
              
            </div>
           
            <div class='col-12 col-md-12 col-sm-12'>
                 <div class="row mt-5">
                     <div class="col-sm-8 col-md-4 col-4 offset-md-1">
                         <img src="images/question.jpg" style='width:200px;' alt="">
                     </div>
                     <div class="col-12 col-sm-1 col-md-2 offset-md-1 offset-sm-1 mt-md-6">
                         <a href='chatbox.php' class='btn btn-success font-2 pl-4  pr-4'>GO</a>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>



<!--<section class='container'>

<div class="row">
           <div class="col-12 text-center mt-5 mb-5">
                <h1 class='font-6'>
                    Reviewing your products 
                </h1>
            </div>  
            
    <div class='col-12 mt-5 mb-5 ml-5'>    
        <div class='row'> 
     <div class="col-4" style='overflow:hidden'>
        <img src="images/student1.jpg" style='height:400px;' alt="">
    </div>
    
    <div class='col-8'>
        <div class="row">
          
            <div class='col-8 offset-md-1'>
               <p class='font-1 text-justify'>You can review your purchased product in this website telling your experience to the world.
                This clears the doubt of the people who want to buy the same product.
                You are just one step away from you first post; you just have to register an account and you are done!

               </p>
              
            </div>
           
            <div class='col-12'>
                 <div class="row mt-5">
                     <div class="col-4 offset-md-1">
                         <img src="images/question.jpg" style='width:200px;' alt="">
                     </div>
                     <div class="col-2 offset-md-1 mt-md-6">
                         <button type='button' class='btn btn-success font-2 pl-4 pr-4'>POST</button>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>-->

<?php include "headerfooter/footer.php"?>


</body>
</html>