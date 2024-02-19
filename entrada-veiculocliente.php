<?php

include ("connection-MySql.php");
include ("crud.php");

$idcliente= $_POST['cliente'];
$cobranca= $_POST['cobranca'];
    
    if(entradaveiculocliente($conexao, $idcliente, $cobranca) != false):
        $_SESSION['entrada'] = 1;  
        header('Location:desktop.php');
    else:
        $_SESSION['entrada'] = 2;
        header('Location:desktop.php');
    endif;




?>