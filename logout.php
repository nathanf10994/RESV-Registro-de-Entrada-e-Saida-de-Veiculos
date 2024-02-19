<?php

    include ("connection-MySql.php");
    include ("crud.php");
    include ("header-desktop.php");

    $_SESSION['login'] = false;
    session_unset(); 
    session_destroy(); 

    header('Location:index.html');

?>