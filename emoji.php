

<div class='whole-emoji'  style='display:inline-block;'>

<div class="container-fluid emoticons"  style=''>
    <div class="row">
     



    <div class="col-12 flex-box-container">
    <?php 
    for($i = 128513 ; $i< 128577 ; $i++)   
    {
        ?>
      
     <div class='individual-emote' onclick='sendemoji(this)'>
       <?php  
       echo "&#".$i ;
       ?>
     </div>      

      
    
<?php
    }
    ?>
   </div>
    </div>
</div>

<div class='emojibutton' onclick='showemojis()'>
       &#128513
</div>
</div>

<script>
    function showemojis()
    {
        var emoticons = document.getElementsByClassName('emoticons')[0]   ;
        if(emoticons.style.display == 'block')
            {
                emoticons.style.display =  'none';
            }
            else
            {
                emoticons.style.display ='block';
            }
    }
</script>