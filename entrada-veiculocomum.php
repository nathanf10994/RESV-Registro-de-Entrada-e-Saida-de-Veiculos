<?php

include ("connection-MySql.php");
include ("crud.php");

$tipo= $_POST['veiculo'];
$cobranca= $_POST['cobranca'];
$placa= $_POST['placaveiculo'];
$veiculo= $_POST['marcamodelo'];
$telefone= $_POST['telefone'];

    if(entradaveiculocomum($conexao, $tipo, $cobranca, $placa, $veiculo, $telefone) != false):
        $_SESSION['entrada'] = 1;  
        header('Location:desktop.php');
    else:
        $_SESSION['entrada'] = 0;
        header('Location:desktop.php');
    endif;

?>
