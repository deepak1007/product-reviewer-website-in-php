<?php

session_start();

session_destroy();
setcookie('login_username', $username , time() - 3600, '/', NULL);


header('location:index.php');

?>