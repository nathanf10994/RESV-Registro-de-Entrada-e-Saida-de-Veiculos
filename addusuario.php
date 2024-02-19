<?php
  
    include ("connection-MySql.php");
    include ("crud.php");

    $status = $_POST['status'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    

    if(addusuario($conexao, $status, $nome, $login, $senha) == true):
        $_SESSION['adduser'] = 1;  
        header('Location:form-settings.php');
    else:
        $_SESSION['adduser'] = 0;
        header('Location:form-seettings.php');
    endif;

?>