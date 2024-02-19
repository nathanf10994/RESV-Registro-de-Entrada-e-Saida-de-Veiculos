<?php

include ("connection-MySql.php");
include ("crud.php");

    $pessoa = select_usuario($conexao,$_POST["login"],$_POST["senha"]);

    if($pessoa == null)
    {
        header('Location:form-erro.php');
    }
    else{
            header('Location:desktop.php');
    }

    $_SESSION['login'] = true;
    $_SESSION['entrada'] = 3;
    $_SESSION['cliente'] = 3;
    $_SESSION['adduser'] = 3;

?>