<?php

if(isset($_POST['topic']))
{   $topic = $_POST['topic'];
    header("location:search.php?topic=$topic&&page=1");
}
