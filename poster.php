<?php 
session_start();
include "config/dbconnect.php";
if(!isset($_SESSION['user_id']))
{?>
   <script>
   alert('please login first');
   window.location.href='index.php' </script>
<?php }
if(isset($_FILES['images']))
{
    $filename = $_FILES['images']['name'];
    $filetype = $_FILES['images']['type'];
    $filetmp  = $_FILES['images']['tmp_name'];
    move_uploaded_file($filetmp, 'images/'. $filename);

    echo json_encode(array('src'=>'images/'.$filename));
    die();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    
    <script src='app.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6567c43039.js" crossorigin='anonymous'></script>
    <title>Document</title>
    <style>
       #title {width:100%; margin:0px 0px 30px 0px; border:1px solid black; padding:10px 10px; border-left:6px solid orange;}
       #title:hover {border:1px solid green; border-left:6px solid green;}
       
         .heading {height:100% !important; }
    .h { font-size:45px;}
    #keywords {width:50%; position:relative ; left:50%; transform:translateX(-50%);margin:20px 0px 20px 0px; padding:5px; border:2px solid black;}
    #category_select_box{display:inline-block;position:relative ; left:50%; transform:translateX(-50%);}
    #category_select_box #category_select {margin-left:10px; padding:3px; font-size:15px; }
    .modal {position:fixed; display:hidden;}
    .modal .modal-background{
        height:100vh;
        background:rgba(0,0,0,0.5);

    }
    .modal .modal-box{
        height:auto;
        position:absolute;
        left:50%;
        top:10px;
        transform: translateX(-50%);
        background:white;
        padding:45px; 
    }
    .modal .modal-box div{
        position:relative;
    }
    .modal .modal-box .header h3, .selector select , .button button {
        position: relative ;
        left:50%;
        transform : translateX(-50%);
    }
    .modal .modal-box .selector select{
        padding:5px 10px;
        font-size:20px;
    }
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
        .modal .modal-box .selector select{
        padding:5px 10px;
        font-size:15px;
    }
    }

    @media (min-width:900px){
        .size-100{height:100vh;}
        .form-element{width:90%}
    }
        </style>
</head>
<body  style='background:rgba(220,220,220,0.1)'>
    <?php include "headerfooter/header.php";
      include "login.php" ;
      include "signup.php"; ?>

    <div class="container-fluid">
        <div class="row">
            
        <div class='col-0 col-sm-12'></div>

            <div class="col-12 mt-3">
              <h2 class='text-center'>Write a Review</h2>
              <hr>
            </div>
        
         
        <div class='col-0 col-sm-12 '></div>
            <div class='col-12'>
            <div class="row">
            <div class="col-xl-3  col-12  order-2 order-lg-0" >
                <div class='suggested_topic_link_box mb-2' id='title-change'>
                    <a href='#section-write-title' title='read this topic'>Step 1 - Writing Title </a>
                </div> 
                <div class='suggested_topic_link_box mb-2' id='content-change'>
                    <a href='#section-write-content' title='read this topic'>Step 2 - Writing Content</a>
                </div> 
                <div class='suggested_topic_link_box mb-2' id='image-added'>
                    <a href='#section-add-image' title='read this topic'> Step 3 - Adding Images</a>
                </div> 
                <div class='suggested_topic_link_box mb-2' id='submited-review'>
                    <a href='#section-submit-review' title='read this topic'>Step 4 - Submiting the review</a>
                </div> 
                
                </div>
                <div class="col-xl-7 col-12 ">

                    <form action="" id='poster-form'>
                    <input type="text" name="title" id="title" class='' placeholder='Title here....'>
                    <script src="ckeditorless/ckeditor/ckeditor.js"></script>
                     <textarea name="editor1"></textarea>
                  
                   <!--  <textarea name='keywords' rows=5 cols=20 id='keywords' placeholder='Enter comma seperated    keywords.  Good keywords will increase the reach of your post'></textarea>
                     <br>
                     <div id='category_select_box'>
                     
                     <select id='category_select' name='category'>
                         <option value='' selected>--select Category--</option>
                     </select>
                     </div>
                    <br>
                    <br>-->


                    <button type='button' class='btn btn-success mt-3 mb-3 pl-4 pr-4' style='position:relative; left:50%; transform:translate(-50%, 0)' id='open_cat'>POST</button>
                    </form>
              
                </div>

             
          </div>
        </div>
          
        </div>
        
    </div>
<hr/>
<div class="container">
        <div class="row">
            <div class="col-12 mb-5 col-md-8 offset-md-2">
                <H2 class='text-center'>HOW TO REVIEW</H2>
            </div>
</div>
</div>

    <section class="container">
        <div class="row">
            
            <div class="col-12">
                <H3 class='text-center mb-md-5 mt-md-5 ' id='section-write-title'>1. Write a Suitable title </h3>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <img src="" alt="">
                    </div>
                    <div class="col-12 col-md-8 offset-md-2">
                        <p class='text-center'>
                            Your reviews must have a suitable and catchy title, as it helps in attracting the readers. A Suitable title should also give the reader knowledge about what is in the content.

</p>
                    </div>
                </div>
            </div>
        </div>
</section>

    <section class="container">
        <div class="row">
            
            <div class="col-12">
                <H3 class='text-center mb-md-5 mt-md-5 ' id='section-write-content'>2. Write the content of your Review </h3>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <img src="" alt="">
                    </div>
                    <div class="col-12 col-md-8 offset-md-2">
                        <p class='text-center '>
                           
                          After a suitable title, now we have to write the content of the review.
                          You can choose to write in default settings or you can give personal touch to the content. There are many features included in the text editor for styling texts, adding links, etc. Make sure the content you write is correct and without mistakes.
                          Also keep it simple so that readers don't find difficulty in reading your reviews.

</p>
                    </div>
                </div>
            </div>
        </div>
</section>


    <section class="container">
        <div class="row">
            
            <div class="col-12" id='section-add-image'>
                <H3 class='text-center mb-md-5 mt-md-5 '>3. Add images to the content </h3>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <img src="" alt="">
                    </div>
                    <div class="col-md-8 offset-md-2 col-12">
                        <p class='text-center'>
                            Adding images of the product is not necessary but it really makes the post attractive. Also images speak more than the textual content. So, we suggest you to add images in your post.

</p>
                    </div>
                </div>
            </div>
        </div>
</section>



    <section class="container">
        <div class="row">
            
            <div class="col-12">
                <H3 class='text-center mb-md-5 mt-md-5 ' id='section-submit-review'>4. Submit the review </h3>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <img src="" alt="">
                    </div>
                    <div class="col-12 col-md-8 offset-md-2">
                        <p class='text-center'>
                           After completing the writing part, now you have to just click on the post button and
                           it would be ready for the world to read it. But you should check for all the possible mistakes first to make it correct.

</p>
                    </div>
                </div>
            </div>
        </div>
</section>

    




<div class="container-fluid">
<div class="row modal">
            <div class="col-12 modal-background">
                  <div>.</div>
            </div>
            <div class="col-10 col-md-6 col-lg-4 modal-box">
                <div>
                <div class="header">
                    <h3 class='text-center'>Select Category</h3>
                </div>
                <div class="selector mt-4">
                    <select name="cat_select" id="cat_select" required>
                    <option value='' class='appends' selected>--select category--</option>
                    <?php
                 $smt = $con->prepare("select * from category");
                 $smt->execute();
                 while($row = $smt->fetch())
                 {
                     ?>
                     <option value='<?php echo $row['serial_no']; ?>' class='appends'><?php echo $row['cat_name']; ?></option>
                     <?php
                 }
                      ?>
                    </select>
                </div>

                <div class="button mt-5">
                    <button class='btn btn-success px-4' onclick='send()'>DONE</button>
                </div>
                </div>
                
            </div>
        </div>
</div>



   
<script>
                      
                     var editor1 =  CKEDITOR.replace( 'editor1', {
                         height: '45vh',
                         filebrowserUploadUrl:"upload.php",
                        filebrowserUploadMethod:"form"
                           });


                        function send(){
                              
                            var form = document.getElementById('poster-form');
                            var category = document.getElementById('cat_select');
                            var category_value = category.options[category.selectedIndex].value;
                            
                            var formdata= new FormData();

                            formdata.append("title", form.title.value);
                            formdata.append("content", editor1.getData());
                           // formdata.append('keywords', document.getElementById('keywords').value);
                           formdata.append('category', category_value);

                            var conn = new XMLHttpRequest();
                            conn.onreadystatechange = function(){
                                
                                if(conn.readyState == 4)
                                {     
                                    var response = JSON.parse(conn.responseText);
                                    
                                    if(response['status']=='200')
                                    {
                                        alert("posted");
                                        window.location.href='postread.php?post_id='+response['data'];
                                    }
                                    else if(response['status']=='201')
                                    {
                                        alert('post unsuccessful');
                                    }
                                    else
                                    {
                                        if(response['status']=='300')
                                        {
                                            alert(response['data']);

                                        }
                                    }
                                }


                            }
                            conn.open("POST", 'restapis/postapi.php?action=makepost', 1);
                            conn.send(formdata);



                        }

$('.modal-background').click(function(){
    $('.modal').hide();
    
});

$('#open_cat').click(function(){
    $('.modal').show();
    
});



$('#cke_371_uiElement').click(function(){

         var input = $('#cke_368_fileInput_input').val();
         if(input != "")
         {
             $('#image-added').css('border-left', '2px solid green')
         }   

});




                
</script>
<?php include "headerfooter/footer.php"?>


</script>
</body>
</html>