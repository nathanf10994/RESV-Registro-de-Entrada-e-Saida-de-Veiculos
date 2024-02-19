<?php

    include ("connection-MySql.php");
    include ("crud.php");
    include ("header-desktop.php");

    $idtipoveiculo = $_GET['idtipoveiculo'];

    $infotipoveiculo = select_update_tipoveiculo($conexao, $idtipoveiculo);

?>

    <style>
      .myDiv {
                padding: 0px 600px;
                text-align: left; } 
    </style>
	<div class="myDiv">

        <br><br><h1><center>Editar Tipo de Veículo</center></h1>

        <form action="editartipoveiculo.php" method="post"> 

            
            ID:
            <input type="tel" class="form-control" id="idtipoveiculo" name="idtipoveiculo" value="<?= $infotipoveiculo['id_tipoveiculo'] ?>" readonly>
            
            TIPO DE VEÍCULO: 
            <input type="text" class="form-control" maxlength="30" size="30" id="tipoveiculo" name="tipoveiculo" value="<?= $infotipoveiculo['tipoveiculo'] ?>" readonly>

            VALOR HORA: 
            <input type="number"  class="form-control" maxlength="4" size="4" id="valorhora" name="valorhora" value="<?= $infotipoveiculo['valorhora'] ?>" required>

            VALOR MINUTO: 
            <input type="number"  class="form-control" maxlength="3" size="3" id="valorminuto" name="valorminuto" value="<?= $infotipoveiculo['valorminuto'] ?>" required>

            VALOR DIÁRIA: 
            <input type="number"  class="form-control" maxlength="5" size="5" id="valordiaria" name="valordiaria" value="<?= $infotipoveiculo['valordiaria'] ?>" required>

            VAGAS TOTAIS: 
            <input type="tel" class="form-control" maxlength="3" size="3" id="vagastotais" name="vagastotais" value="<?= $infotipoveiculo['vagastotais'] ?>" required>

            <br><center>
            <input class="btn btn-primary" type="submit" value="Atualizar"/>
            <a class="btn btn-danger" type="submit" href="form-settings.php">Voltar</a>
            </center>


        </form>

    </div>

<?php 
    include ("footer-desktop.php");
?>