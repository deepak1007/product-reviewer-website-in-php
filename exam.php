<?php
session_start();

if(isset($_POST['next']))
{
   /* 
   $resut = mysqli_query($conn, "insert into table name values('student_id', 'question_id', 'answer_submitted', 'test_name'));
   
   */

}


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
  <button type="button" class="btn" onclick="window.location.href = 'result.php';"> Result </button>
  <button type="button" class="btn btn-warning" onclick="window.location.href = 'logout.php';"> Logout <i class='fas fa-lock'></i> </button>
</div>
</div>
</div>


<div id="home">
<br/><br/> 
<center><div style="border:2px solid black;  height:500px; width:70%; background-color: AliceBlue; color:black;">
<div style="border-bottom:1px solid red; height:70px; width:100%; padding:2px; padding-left:20px; padding-top:20px; text-align:center; text-shadow: 2px 2px 2px greenyellow;">
 <div style="text-align:left; font-size:2.5em;">Time: <span id="time">60:00</span></div>
</div>
<br/>
<div style="border:none; height:320px; width:100%; padding-left:20px;  padding-top:20px; text-align:center; text-shadow: 2px 2px 2px greenyellow;">
<?php
error_reporting(0);

$_session["sid"]=$_GET["subid"];    
$sid=$_session["sid"];              

include("config.php");
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
$rs = mysqli_fetch_assoc($queResult);
	
	$qid=$rs['qid'];
	$qno=$rs['qno'];
	$que=$rs['que'];
	$op1=$rs['op1'];
	$op2=$rs['op2'];
	$op3=$rs['op3'];
	$op4=$rs['op4'];
	$correct=$rs['correct'];
?>

<form style="text-align:left;" action='?subid=<?php echo $sid; ?>&&page=<?php echo $nextPage; ?>' id='form1' method="post">
<p style="text-align:left;"><b>Q.<?php echo $qno."."." ".$que;?> </b></p>

A) <?php echo $op1; ?> <input type="radio" name="ans" required="true" value="a" id="Radio1" onclick="disable()"> <br/>
B) <?php echo $op2; ?> <input type="radio" name="ans" value="b" id="Radio2" onclick="disable()"> <br/>
C) <?php echo $op3; ?> <input type="radio" name="ans" value="c" id="Radio3" onclick="disable()"> <br/>
D) <?php echo $op4; ?> <input type="radio" name="ans" value="d" id="Radio4" onclick="disable()"> <br/>

<?php  ?>

</form>

<script>
function disable() {
  document.getElementById("Radio1").disabled = true;
  document.getElementById("Radio2").disabled = true;
  document.getElementById("Radio3").disabled = true;
  document.getElementById("Radio4").disabled = true;
}
</script>

</div>

<?php

 

?>

<div style="border:none; height:70px; width:100%; padding-bottom:20px; padding-right:20px;  text-align:right;">
<div class="pagination">  
<?php if($currentPage != $lastPage) { ?>
 
<input type="hidden" name="hidden" value="<?php echo $qid; ?>">
<button class="btn" type="submit" name="next" onclick="send()">Next Question</button>

 <?php } ?>

</div>

<?php

if(isset($_POST["next"]))
{	
    $next=$_POST["hidden"];
	echo "<script> alert('$next'); </script>";
}
	

?>

</div>
</div></center>

</div>
<script>

function send(){
  
  var form = document.getElementById('form1');
  form.submit();


}
</script>
</body>
</html>