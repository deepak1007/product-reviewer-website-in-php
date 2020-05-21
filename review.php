<?php
session_start();
include("config.php");

$_SESSION["sid"]=$_GET["subid"];
$sid=$_SESSION["sid"];       
$userid=$_SESSION["uid"]; 




$query="select * from subject where subid='$sid'";
$check=mysqli_query($conn,$query);
$tr=mysqli_fetch_array($check);

$_SESSION["subname"]=$tr['subname'];

?>

<html>
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>

 <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Examin - Education and LMS Template">

    <!-- ========== Page Title ========== -->
    

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/flaticon-set.css" rel="stylesheet" />
    <link href="assets/css/magnific-popup.css" rel="stylesheet" />
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/css/owl.theme.default.min.css" rel="stylesheet" />
    <link href="assets/css/animate.css" rel="stylesheet" />
    <link href="assets/css/bootsnav.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5/html5shiv.min.js"></script>
      <script src="assets/js/html5/respond.min.js"></script>
    <![endif]-->

    <!-- ========== Google Fonts ========== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">

<script>
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

window.onload = function () {
    var fiveMinutes = 60 * 60,
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};
</script>

<style>

#top{
   
   width:100%;
   height:250px;
   background-image: url(header.jpg);
   background-repeat: no-repeat;  
   background-size: 100% 100%;   
   color:black; 
}


#menu{
    	line-height:30px; 
		background-color:black; 
		height:*; 
		width:20%;
		float:left;  
		padding-left:25px;
		
}


#home{
	background-color:Beige ; 
	height:600px; 
	width:100%;  
	color: black ;
}
		
#footer{
     background-color:white; 
	 color:black; 
	 text-align:center;
     height:*; 
     width:*;
     margin-left:10px;
     margin-right: 10px;
     	 
}
		
div.static
{
position: static;
background-color:white;
padding-left: 10px;
padding-right: 10px;
height:40px;
}

div.sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  
  background-color: white;
  padding-left:50px;
  padding-right:2px;
  height: 80px;
  z-index:9999;
  margin: 0 0 0 0px;
}

.pagination button {
  color: white;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid black;
  font-size: 15px;
  background-color: blue;
}

.pagination button:hover:not(.active) {background-color: blue; color:white;}

body 
{
  margin:0 0 0 0px;
}

</style>
</head>

<body>

<div id="top"></div>

<div class="sticky"><br/> 
<img src="logo.png" style="float:left;"></img> 
<div class="container">
<div class="btn-group btn-group-lg" style="float:right; button-color:white;">
  <button type="button" class="btn" onclick="window.location.href = 'home.php';"> Home </button>
  <button type="button" class="btn" onclick="window.location.href = 'subjects.php';"> Subjects </button>
  <button type="button" class="btn" onclick="window.location.href = 'result2.php';"> Result </button>
  <button type="button" class="btn btn-warning" onclick="window.location.href = 'logout.php';"> Logout <i class='fas fa-lock'></i> </button>
</div>
</div>
</div>


<div id="home">
<br/><br/> 
<center><div style="border:2px solid black;  height:500px; width:70%; background-color: AliceBlue; color:black;">
<div style="border-bottom:1px solid red; height:70px; width:100%; padding:2px; padding-left:20px; padding-top:20px; text-align:center; text-shadow: 2px 2px 2px greenyellow;">
 <!--
 <div style="text-align:left; font-size:2.5em;">Time: <span id="time">60:00</span></div>
 -->
</div>
<br/>
<div style="border:none; height:320px; width:100%; padding-left:20px;  padding-top:20px; text-align:center; text-shadow: 2px 2px 2px greenyellow;">
<?php
error_reporting(0);



$showRecordPerPage = 1;
if(isset($_GET['page']) && !empty($_GET['page'])){
$currentPage = $_GET['page'];
}else{
$currentPage = 1;
}
$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
$totalque = "SELECT * FROM question where subid='$sid'";
$allqueResult = mysqli_query($conn, $totalque);
$totalQues = mysqli_num_rows($allqueResult);
$lastPage = ceil($totalQues/$showRecordPerPage);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;
$queSQL = "SELECT * FROM question where subid='$sid' 
LIMIT $startFrom, $showRecordPerPage";
$queResult = mysqli_query($conn, $queSQL);
?>

<?php

$tot_que=$totalQues;
$_SESSION["totalque"]=$tot_que;

$rs = mysqli_fetch_assoc($queResult);
	
	$qid=$rs['qid'];
	$qno=$rs['qno'];
	$que=$rs['que'];
	$op1=$rs['op1'];
	$op2=$rs['op2'];
	$op3=$rs['op3'];
	$op4=$rs['op4'];
  $correct=$rs['correct'];
  

  /*change the column name and the variable name in this query according to your table */

  $queSQL = "SELECT ans from userans where $user_id='$user_id' and $sub_id='$sub_id' and qid = '$qid'";
  $useransresult = mysqli_query($conn, $queSQL);
   
   $user_answer_for_this_question = $useransresult['ans'];


   /* ------------------------------*/


?>

<?php 
if($currentPage != $lastPage) 
{ 
?>

<form style="text-align:left;" action='review.php?subid=<?php echo $sid; ?>&&page=<?php echo $nextPage; ?>' id='form1' method="post">
<p style="text-align:left;"><b>Q.<?php echo $qno."."." ".$que;?> </b></p>


<?php 
} 
else if($currentPage == $lastPage)
{
?>	
 
<form style="text-align:left;" action='result.php?subid=<?php echo $sid; ?>' id='form1' method="post">
<p style="text-align:left;"><b>Q.<?php echo $qno."."." ".$que;?> </b></p>

 
<?php
}
?>
<?php 
 if($user_answer_for_this_question== $op1)
 { if( $correct == $op1)
  {
    echo '<div style="color:green">A) ' .$op1 .' <input type="radio" name="ans" selected value="a" id="Radio1" disabled> carrect </div> <br/>';
  }
  else
  {
    echo '<div style="color:red">A)  $op1 <input type="radio" name="ans" selected value="a" disabled id="Radio1"> wronge </div> <br/>';
  }
 }
 else
 {
  if( $correct == $op1)
  {
    echo '<div style="color:green">A)  $op1 <input type="radio" name="ans" value="a" id="Radio1" disabled> right answer </div> <br/>';
  }
  else
  {
    echo '<div>A) <?php echo $op1; ?> <input type="radio" name="ans"  value="a" disabled id="Radio1"> wronge </div> <br/>';
  }
 }
 
 if($user_answer_for_this_question == $op2)
 { if($correct == $op2)
  {
    echo '<div style="color:green">B) <?php echo $op2; ?> <input type="radio" selected disabled name="ans" value="b" id="Radio2" > correct </div> <br/>';
  }
  else
  {
    echo '<div style="color:red">B) <?php echo $op2; ?> <input type="radio" selected disabled name="ans" value="b" id="Radio2" > wrange </div> <br/>';
  }
 }
 else
 {
  if($correct == $op2)
  {
    echo '<div style="color:green">B) <?php echo $op2; ?> <input type="radio" disabled name="ans" value="b" id="Radio2" > right answer </div> <br/>';
  }
  else
  {
    echo '<div>B) <?php echo $op2; ?> <input type="radio" disabled name="ans" value="b" id="Radio2" ></div> <br/>';
  }
  
 }

 if($user_answer_for_this_question == $op3)
 { if($correct == $op3)
  {
    echo '<div style="color:green">C) <?php echo $op3; ?> <input type="radio" selected disabled name="ans" value="c" id="Radio3" > carrect </div> <br/>';
  }
  else
  {
    echo '<div style="color:red">C) <?php echo $op3; ?> <input type="radio" selected disabled name="ans" value="c" id="Radio3" > wrange </div> <br/>';
  }
 }
 else
 {
  if($correct == $op3)
  {
    echo '<div style="color:green">C) <?php echo $op3; ?> <input type="radio" disabled name="ans" value="c" id="Radio3" > right answer </div> <br/>';
  }
  else
  {
    echo '<div>C) <?php echo $op3; ?> <input type="radio"  disabled name="ans" value="c" id="Radio3" ></div> <br/>';
  }
 }

 if($user_answer_for_this_question== $op4)
 { if($correct == $op4)
  {
    echo '<div style="color:green">D) <?php echo $op4; ?> <input type="radio" name="ans" selected value="d" disabled id="Radio4"> carrect </div> <br/>';
  }
  else
  {
    echo '<div style="color:red">D) <?php echo $op4; ?> <input type="radio" name="ans" selected disabled value="d" id="Radio4"> wrange </div> <br/>';
  }
 }
 else
 {
  if($correct == $op4)
  {
    echo '<div style="color:green">D) <?php echo $op4; ?> <input type="radio" name="ans" value="d" disabled id="Radio4"> right answer </div> <br/>';
  }
  else
  {
    echo '<div>D) <?php echo $op4; ?> <input type="radio" name="ans" disabled value="d" id="Radio4"></div> <br/>';
  }
 }





?>


<input type='hidden' value='<?php echo $qid; ?>' name='qid'>
<?php  ?>
<input type='submit' id='save' style='visibility:hidden' name='save' value='submit'>
</form>


</div>

<?php

 

?>

<div style="border:none; height:70px; width:100%; padding-bottom:20px; padding-right:20px;  text-align:right;">
<div class="pagination">  
<?php 
if($currentPage != $lastPage) 
{ 
?>

<button class="btn" type="button" name="next" onclick="send()">Next Question</button>

<?php 
} 
else if($currentPage == $lastPage)
{
?>	
 
<button class="btn" type="button" name="next" onclick="send()">Get Result</button>

 
<?php
}
?>

</div>

<?php


	

?>

</div>
</div></center>

</div>
<script>

function send(){
  
  var input = document.getElementById('save');
  input.click();


}
</script>
</body>
</html>