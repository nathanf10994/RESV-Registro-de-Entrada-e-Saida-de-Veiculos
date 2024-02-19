<?php

    include ("connection-MySql.php");
    include ("crud.php");

    $_SESSION['page'] = 1;

    include ("header-desktop.php");

    if($_SESSION['login'] != true):
        header('Location:form-erro.php');
    endif;

?>


	<!--Entrada de Veículos-->
    <br><br><h1><center>Entrada de Veículos</center></h1>

    <br><h5><center>Não-Clientes</center></h5></p>
    
    
    <center> 

        <form action="entrada-veiculocomum.php" method="post">
        
            TIPO DE VEÍCULO:
            <select id="veiculo" name="veiculo" required>
                <option></option>
                <option value="1">MOTOCICLETA</option>
                <option value="2">PEQUENO PORTE</option>
                <option value="3">MEDIO PORTE</option>
                <option value="4">GRANDE PORTE</option>
            </select>
        
            TIPO DE COBRANÇA:
            <select id="cobranca" name="cobranca" required>
                <option></option>
                <option value="1">TEMPO</option>
                <option value="2">DIÁRIA</option>
            </select>
        
            PLACA:
            <input type="text" minlength="7" maxlength="7" size="7" id="placaveiculo" name="placaveiculo" required>

            VEÍCULO:
            <input type="text" maxlength="30" size="30" id="marcamodelo" name="marcamodelo" required>
       
            TELEFONE:
            <input type="tel" minlength="10" maxlength="11" size="11" id="telefone" name="telefone" required>

            <input class="btn btn-primary" type="submit" name="entrar" value="Entrar"/>

        </form>

    </center>

    <br><h5><center>Clientes</center></h5></p> 

    <center> 

        <form action="entrada-veiculocliente.php" method="post">

            ID CLIENTE:
            <input type="tel" maxlength="4" size="4" id="cliente" name="cliente" required>

            TIPO DE COBRANÇA:
            <select id="cobranca" name="cobranca" required>
                <option></option>
                <option value="1">TEMPO</option>
                <option value="2">DIÁRIA</option>
                <option value="3">MENSALISTA</option>
            </select>

            <input class="btn btn-primary" type="submit" name="entrar" value="Entrar">

        </form>

    </center>  

    <?php

        if($_SESSION['entrada'] == 1):
            echo "<hr><center><font size='6' color='#00a8ff'>Entrada Bem-Sucedida</font></center>";
            $_SESSION['entrada'] = 3;
        elseif($_SESSION['entrada'] == 0):
            echo "<hr><center><font size='6' color='#cc3300'>Vaga Indisponivel</font></center>";
            $_SESSION['entrada'] = 3;
        elseif($_SESSION['entrada'] == 2):
            echo "<hr><center><font size='6' color='#cc3300'>Cadastro Não-Encontrado</font></center>";
            $_SESSION['entrada'] = 3;
        endif;
        
    ?>



    <!--Contagem de Vagas-->

      
            <hr>
            <center><b><font size="5"> VAGAS DISPONÍVEIS   </font></b>
            MOTOCICLETAS:   <?php vagasmotos($conexao) ?>
            PEQUENO PORTE:  <?php vagaspequeno($conexao) ?>
            MÉDIO PORTE:    <?php vagasmedio($conexao) ?>
            GRANDE PORTE:   <?php vagasgrande($conexao) ?>
            </center>
            <hr>

  
    <!--Tabela Veículos Estacionados-->

    
    <br><h1><center>Veículos Estacionados</center></h1>

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
            <th><b> TIPO DE COBRANCA </b></th>
            <th><b> PLACA </b></th>
            <th><b> MARCA/MODELO </b></th>
            <th><b> TELEFONE </b></th>
            <th><b> DATA/HORA ENTRADA </b></th>
            <th><b> SAIR </b></th>
    </tr>
<?php

    $listaregistroveiculo = select_veiculosestacionados($conexao);
    
    foreach ($listaregistroveiculo as $registroveiculo):

?>

    <tr>
    <td><?= $registroveiculo['id_estacionamento'] ?></td>
    <td><?= $registroveiculo['tipoveiculo']   ?></td>
    <td><?= $registroveiculo['cobranca']  ?></td>
    <td><?= $registroveiculo['placa']  ?></td>
    <td><?= $registroveiculo['marcamodelo']  ?></td>
    <td><?= $registroveiculo['telefone']  ?></td>
    <td><?= $registroveiculo['dhentrada']  ?></td>
    <td><a class = "btn btn-primary" href ="saidaveiculo.php?idestacionamento=<?= $registroveiculo['id_estacionamento'] ?>
        &cobranca=<?= $registroveiculo['cobranca'] ?>">Sair</td>
</tr>

<?php
    endforeach
?>
</table>

</div>

<?php
    include ("footer-desktop.php");
?>