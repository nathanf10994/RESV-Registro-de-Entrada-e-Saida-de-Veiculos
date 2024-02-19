<?php

    include ("connection-MySql.php");
    include ("crud.php");
    include ("header-desktop.php");

    $idplano = $_GET['idplano'];

    $infoplano = select_update_plano($conexao, $idplano);

?>

    <style>
      .myDiv {
                padding: 0px 600px;
                text-align: left; } 
    </style>
	<div class="myDiv">

        <br><br><h1><center>Editar Plano</center></h1>

        <form action="editarplano.php" method="post"> 

            
            ID:
            <input type="tel" class="form-control" id="idplano" name="idplano" value="<?= $infoplano['id_plano'] ?>" readonly>
            
            PLANO: 
            <input type="text" class="form-control" maxlength="30" size="30" id="plano" name="plano" value="<?= $infoplano['plano'] ?>" readonly>

            VALOR PLANO: 
            <input type="number"  class="form-control" maxlength="4" size="4" id="valorplano" name="valorplano" value="<?= $infoplano['valorplano'] ?>" required>

            <br><center>
            <input class="btn btn-primary" type="submit" value="Atualizar"/>
            <a class="btn btn-danger" type="submit" href="form-settings.php">Voltar</a>
            </center>


        </form>

    </div>

<?php 
    include ("footer-desktop.php");
?>