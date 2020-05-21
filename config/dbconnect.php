<?php

try{
    $con = new PDO('mysql:host=localhost;dbname=reviewer', 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}
catch(PDOException $e)
{
   echo "<script>alert(" .$e->getMessage() . ") </script>";
}
?>