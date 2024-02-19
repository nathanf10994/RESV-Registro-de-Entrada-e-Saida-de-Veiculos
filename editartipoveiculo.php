<?php

include ("connection-MySql.php");
include ("crud.php");

    $idtipoveiculo = $_POST['idtipoveiculo'];
    $valorhora = $_POST['valorhora'];
    $valorminuto = $_POST['valorminuto'];
    $valordiaria = $_POST['valordiaria'];
    $vagastotais = $_POST['vagastotais'];
    

if(editatipoveiculo($conexao, $idtipoveiculo, $valorhora, $valorminuto, $valordiaria, $vagastotais) == true):
    $_SESSION['adduser'] = 4;  
    header('Location:form-settings.php');
else:
    $_SESSION['adduser'] = 0;
    header('Location:form-settings.php');
endif;


?>