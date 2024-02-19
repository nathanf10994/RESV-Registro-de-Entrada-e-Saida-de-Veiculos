<?php

include ("connection-MySql.php");
include ("crud.php");

    $status = $_POST['status'];
    $idusuario = $_POST['idusuario'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    

if(editausuario($conexao, $status, $idusuario, $nome, $login, $senha) == true):
    $_SESSION['adduser'] = 2;  
    header('Location:form-settings.php');
else:
    $_SESSION['adduser'] = 0;
    header('Location:form-settings.php');
endif;


?>