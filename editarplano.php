<?php

include ("connection-MySql.php");
include ("crud.php");

    $idplano = $_POST['idplano'];
    $valorplano = $_POST['valorplano'];
       

if(editaplano($conexao, $idplano, $valorplano) == true):
    $_SESSION['adduser'] = 5;  
    header('Location:form-settings.php');
else:
    $_SESSION['adduser'] = 0;
    header('Location:form-settings.php');
endif;


?>