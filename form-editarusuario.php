<?php

    include ("connection-MySql.php");
    include ("crud.php");
    include ("header-desktop.php");

    $idusuario = $_GET['idusuario'];

    $infousuario = select_update_usuario($conexao, $idusuario);

?>

    <style>
      .myDiv {
                padding: 0px 600px;
                text-align: left; } 
    </style>
	<div class="myDiv">

        <br><br><h1><center>Editar Usuário</center></h1>

        <form action="editarusuario.php" method="post"> 

            STATUS: 
            <select id="status" name="status" class="form-control" required>
                <option></option>
                <option value="1">ADMINISTRADOR</option>
                <option value="2">FUNCIONÁRIO</option>
                <option value="3">INATIVO</option>
            </select>

            ID:
            <input type="tel" class="form-control" id="idusuario" name="idusuario" value="<?= $infousuario['id_usuario'] ?>" readonly>
            
            NOME: 
            <input type="text" class="form-control" maxlength="30" size="30" id="nome" name="nome" value="<?= $infousuario['nome'] ?>" required>

            LOGIN: 
            <input type="text"  class="form-control" maxlength="15" size="15" id="login" name="login" value="<?= $infousuario['login'] ?>" required>

            SENHA: 
            <input type="password" class="form-control" maxlength="7" size="8" id="senha" name="senha" required>

            <br><center>
            <input class="btn btn-primary" type="submit" value="Atualizar"/>
            <a class="btn btn-danger" type="submit" href="form-settings.php">Voltar</a>
            </center>


        </form>

    </div>

<?php 
    include ("footer-desktop.php");
?>