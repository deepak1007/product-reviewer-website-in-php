<?php 

if(isset($_FILES['images']))
{
    $filename = $_FILES['images']['name'];
    $filetype = $_FILES['images']['type'];
    $filetmp  = $_FILES['images']['tmp_name'];
    move_uploaded_file($filetmp, '../images/'. $filename);

    echo json_encode(array('src'=>'../images/'.$filename));
    die();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>
    <title>Document</title>
    <style>
         .heading {height:100% !important; }
    .h { font-size:45px;}
    .font-1 {font-size:22px;}
    .font-2 {font-size:25px;}
    .font-3 {font-size:30px}
    .font-4 {font-size:34px};
    .font-5 {font-size:40px;}
    .font-6 {font-size :43px;}
    .mt-md-6 {margin-top:70px;}
    .ml-md-6 { margin-left:70px;}
    @media(max-width:900px) {
        .form-element{width:80%; margin:10px; }
    }

    @media (min-width:900px){
        .size-100{height:100vh;}
        .form-element{width:90%}
    }
        </style>
</head>
<body>
    <?php include "../headerfooter/header.php"; ?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-5 col-xl-2 offset-1" style='overflow:hidden;'>
                <div class="row">
                    <div class="col-12 col-xl-12 mt-md-6">
                        <img src="../images/women1.jpg" style='width:80%; height:100% ;' alt="">
                        <!-- profile pic -->
                    </div>
                    <div class="col-10 col-xl-10 text-center">
                        Deepak Sharma <!-- name -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 ml-md-5 ml-1">
             <div class="row">
                <div class="col-12 mt-md-6">
                <form>
                  <label for='FirstName'>First Name : </label>
                  <input type='text' name = 'FirstName' placeholder = "ex : Deepak"><br>
                  <label for="LastName">Last Name :</label>
                   <input type="text" name="LastName" id="" placeholder="ex : Sharma"><br>
                   <label for="dob">DOB :</label>
                   <select name="dd" id="">
                       <?php
                       for($i=1; $i<=31; $i++)
                       {
                           echo "<option>". $i . "</option>";
                       }
                       ?>
                   </select>
                   <select name="mm" id="">
                       <?php
                       for($i=1; $i<=12; $i++)
                       {
                           echo "<option>". $i . "</option>";
                       }
                       ?>
                   </select>
                   <select name="yy" id="">
                       <?php
                       for($i=1900; $i<=2002; $i++)
                       {
                           echo "<option>". $i . "</option>";
                       }
                       ?>
                   </select>

                   <input type="text" name="" id="">
              </form>
                </div>
             
             </div>
        
            </div>
           

        </div>
    </div>

    
<script>

var inpimage = document.getElementById('inputimages');
var media = new Object();



var form = new FormData();


 function change()
    {   try {
        
        
        var file = inpimage.files[0];
        form.set('images', file);
        var con = new XMLHttpRequest();
        con.onreadystatechange = function()
        {
            if(con.readyState == 4 )
            {
                    var response  = JSON.parse(con.responseText);
                    var image = document.createElement('img');
                    image.src = response['src'];
                    image.setAttribute('class', 'thumbnail mt-xl-5');
                    image.style.width = "80%";
                    var content = document.getElementById('content');
                    var length  = content.value.length;
                    media[length] = media[length]!=null? media[length] : [];
                    media[length].push(response['src']);
                    var place = document.getElementsByClassName('image-show')[0];
                    place.appendChild(image);
            }
        }
        con.open("POST", '', true);
        con.send(form);
        
       
    }      
    
catch(e)
{
    console.log(e)
}
}

</script>
</body>
</html>