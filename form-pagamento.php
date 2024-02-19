<?php

    include ("connection-MySql.php");    
    include ("crud.php");
    include ("header-desktop.php");

    $idestacionamento = $_SESSION['idestacionamento'];

    $infopagamento= valorpagamento($conexao, $idestacionamento);

?>

    <style>
        .myDiv {
            padding: 120px 500px;
            text-align: left;
            }
    </style>

    <div class="myDiv">
    <table class = "table">


<tr>
    <tr>
        <th><font size="4">ID Estacionamento:</th>
        <td><font size="4" color="#00a8ff"><?= $idestacionamento ?></td>
    </tr>
    <tr>
        <th><font size="4">Tipo de Cobranca:</th>
        <td><font size="4" color="#00a8ff"><?= $infopagamento['tipocobranca'] ?></td><tr>
    <tr>
        <th><font size='4'>Data/Hora Entrada:</th>
        <td><font size='4' color='#00a8ff'><?= $infopagamento['dhentrada'] ?></td><tr>
    <tr>
        <th><font size='4'>Data/Hora Saída:</th>
        <td><font size='4' color='#00a8ff'><?= $infopagamento['dhsaida'] ?></td><tr>
    <tr>
        <th><font size='4'>Tempo Total:</th>
        <td><font size='4' color='#00a8ff'><?= $infopagamento['tempototal'] ?></td><tr>
    <tr>
        <th><font size="4">Valor:</th>
        <td><font size="4" color="#cc3300">R$ <?= $infopagamento['valor'] ?></td><tr>
</tr>

    </table>
    </div>

        <center><a class="btn btn-primary" href="desktop.php">Voltar ao Home</a></center>
    

<?php 
    include ("footer-desktop.php");
?>