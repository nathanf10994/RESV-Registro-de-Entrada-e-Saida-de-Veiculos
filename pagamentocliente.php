<?php

    include ("connection-MySql.php");    
    include ("crud.php");
    include ("header-desktop.php");

    $idcliente = $_GET['idcliente'];

    pagamentocliente($conexao, $idcliente);

    $infopagcliente= valorpagamentocliente($conexao, $idcliente)

?>

    <style>
        .myDiv {
            padding: 100px 500px;
            text-align: left;
            }
    </style>

    <div class="myDiv">
    <table class = "table">

    <tr>
        <tr>
            <th><font size="4">ID Cliente:</th>
            <td><font size="4" color="#00a8ff"><?= $idcliente ?></td>
        </tr>
        <tr>
            <th><font size="4">Plano:</th>
            <td><font size="4" color="#00a8ff"><?= $infopagcliente['plano'] ?></td>
        </tr>
        <tr>
            <th><font size='4'>Valor Plano:</th>
            <td><font size='4' color='#cc3300'><?= $infopagcliente['valorplano'] ?></td>
        </tr>
        <tr>
            <th><font size='4'>Data Pagamento:</th>
            <td><font size='4' color='#00a8ff'><?= $infopagcliente['datapagamento'] ?></td>
        </tr>
        <tr>
            <th><font size='4'>ID Pagamento:</th>
            <td><font size='4' color='#00a8ff'><?= $infopagcliente['id_pagamento'] ?></td>
        </tr>
        
    </table>
    </div>

    <center><a class="btn btn-primary" href="desktop.php">Voltar ao Home</a></center>


<?php 

    include ("footer-desktop.php");
?>


