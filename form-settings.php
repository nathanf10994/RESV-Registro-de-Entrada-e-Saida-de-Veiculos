<?php

    include ("connection-MySql.php");
    include ("crud.php");

    $_SESSION['page'] = 4;

    include ("header-desktop.php");

    if($_SESSION['login'] != true):
        header('Location:form-erro.php');
    endif;

    if($_SESSION['status'] != 1):
        header('Location:form-acesso-negado.php');
    endif;

?>

<!-- Cadastro de Novo Usuário -->

<br><br><h1><center>Cadastrar Novo Usuário</center></h1>

<br><center> 

        <form action="addusuario.php" method="post"> 

            STATUS: 
            <select id="status" name="status"  required>
                <option></option>
                <option value="1">ADMINISTRADOR</option>
                <option value="2">FUNCIONÁRIO</option>
            </select>

            NOME: 
            <input type="text" maxlength="30" size="30" id="nome" name="nome"  required>

            LOGIN: 
            <input type="text"  maxlength="15" size="15" id="login" name="login"  required>

            SENHA: 
            <input type="password" maxlength="7" size="8" id="senha" name="senha"  required>

            <input class="btn btn-primary" type="submit" value="CADASTRAR"/>

        </form>

        <?php

        if($_SESSION['adduser'] == 1):
            echo "<hr><center><font size='6' color='#00a8ff'>Usuario cadastrado com sucesso</font></center>";
            $_SESSION['adduser'] = 3;
        elseif($_SESSION['adduser'] == 0):
            echo "<hr><center><font size='6' color='#cc3300'>Erro no cadastro/atualização</font></center>";
            $_SESSION['adduser'] = 3;
        elseif($_SESSION['adduser'] == 2):
                echo "<hr><center><font size='6' color='#00a8ff'>Atualização de Usuário feita com sucesso</font></center>";
                $_SESSION['adduser'] = 3;
        elseif($_SESSION['adduser'] == 4):
                echo "<hr><center><font size='6' color='#00a8ff'>Atualização de Tipo de veículo feita com sucesso</font></center>";
                $_SESSION['adduser'] = 3;
        elseif($_SESSION['adduser'] == 5):
            echo "<hr><center><font size='6' color='#00a8ff'>Atualização de Plano feita com sucesso</font></center>";
            $_SESSION['adduser'] = 3;
        endif;

        ?>

    </center>

<!-- Tabela Usuários -->

<hr><h1><center>Usuários</center></h1>

    <style>
      .myDiv {
                padding: 20px 100px;
                text-align: center; }
  	</style>


	<div class="myDiv">
	<table class="table table-hover">

    <tr>
            <th><b> ID </b></th>
            <th><b> STATUS </b></th>
            <th><b> NOME DO USUÁRIO</b></th>
            <th><b> LOGIN </b></th>
            <th><b> SENHA </b></th>
            <th><b> EDITAR </b></th>
    </tr>

<?php

    $listausuario = select_user($conexao);
    foreach ($listausuario as $usuario):

?>

    <tr>
    <td><?= $usuario['id_usuario'] ?></td>
    <td><?= $usuario['status']   ?></td>
    <td><?= $usuario['nome']  ?></td>
    <td><?= $usuario['login']  ?></td>
    <td> ###### </td>
    <td><a class = "btn btn-info" href = "form-editarusuario.php?idusuario=<?=$usuario['id_usuario']?>">Editar</a></td>
</tr>

<?php
    endforeach
?>
</table>
</div>

<!--Tabela Tipos de veículo-->

<br><br><h1><center>Tipos de Veículo</center></h1>

    <style>
      .myDiv {
                padding: 20px 100px;
                text-align: center; }
  	</style>


<div class="myDiv">
	<table class="table table-hover">

    <tr>
            <th><b> ID </b></th>
            <th><b> TIPO DE VEÍCULO </b></th>
            <th><b> VALOR HORA </b></th>
            <th><b> VALOR MINUTO </b></th>
            <th><b> VALOR DIÁRIA </b></th>
            <th><b> VAGAS TOTAIS </b></th>
            <th><b> EDITAR </b></th>
    </tr>

<?php

    $listatipoveiculo = select_tipoveiculo($conexao);
    foreach ($listatipoveiculo as $veiculo):

?>

    <tr>
    <td><?= $veiculo['id_tipoveiculo'] ?></td>
    <td><?= $veiculo['tipoveiculo']   ?></td>
    <td>R$ <?= $veiculo['valorhora']  ?></td>
    <td>R$ <?= $veiculo['valorminuto']  ?></td>
    <td>R$ <?= $veiculo['valordiaria']  ?></td>
    <td><?= $veiculo['vagastotais']  ?></td>
    <td><a class = "btn btn-info" href = "form-editartipoveiculo.php?idtipoveiculo=<?=$veiculo['id_tipoveiculo']?>">Editar</a></td>
</tr>

<?php
    endforeach
?>
</table>
</div>

<!--Tabela planos-->

<br><br><h1><center>Planos</center></h1>

<div class="myDiv">
	<table class="table table-hover">

    <tr>
            <th><b> ID </b></th>
            <th><b> PLANO </b></th>
            <th><b> VALOR PLANO </b></th>
            <th><b> EDITAR </b></th>
    </tr>

<?php

    $listaplano = select_plano($conexao);
    foreach ($listaplano as $plano):

?>

    <tr>
    <td><?= $plano['id_plano'] ?></td>
    <td><?= $plano['plano']   ?></td>
    <td><?php if($plano['plano'] != 'Cliente Frequente'): ?> R$ <?= $plano['valorplano']  ?><?php else: echo "****"; endif ?></td>
    <td><?php if($plano['plano'] != 'Cliente Frequente'): ?><a class = "btn btn-info" href = "form-editarplano.php?idplano=<?=$plano['id_plano']?>">Editar <?php else: echo "****"; endif ?></a></td>
</tr>

<?php
    endforeach
?>
</table>
</div>


<?php 
    include ("footer-desktop.php");
?>