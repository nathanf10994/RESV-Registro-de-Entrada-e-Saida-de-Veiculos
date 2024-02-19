<?php

    include ("connection-MySql.php");
    include ("crud.php");

    $_SESSION['page'] = 2;

    include ("header-desktop.php");

    if($_SESSION['login'] != true):
        header('Location:form-erro.php');
    endif;

?>

<br><br><h1><center>Cadastrar Novo Cliente</center></h1>

<br><center> 

        <form action="addcliente.php" method="post">

            NOME DO CLIENTE: 
            <input type="text" maxlength="30" size="30" id="cliente" name="cliente" required>

            CPF/CNPJ: 
            <input type="tel" minlength="11" maxlength="14" size="14" id="cpfcnpj" name="cpfcnpj" required>

            TELEFONE: 
            <input type="tel" minlength="10" maxlength="11" size="11" id="telefone" name="telefone" required>

            PLACA: 
            <input type="text" minlength="7" maxlength="7" size="7" id="placa" name="placa" required>

            MARCA/MODELO:  
            <input type="text" maxlength="30" size="30" id="marcamodelo" name="marcamodelo" required>

            <br><br>
        
            TIPO DE VEÍCULO: 
            <select id="veiculo" name="veiculo" required>
                <option></option>
                <option value="1">MOTOCICLETA</option>
                <option value="2">PEQUENO PORTE</option>
                <option value="3">MEDIO PORTE</option>
                <option value="4">GRANDE PORTE</option>
            </select>
        
            PLANO: 
            <select id="plano" name="plano" required>
                <option></option>
                <option value="1">CLIENTE FREQUENTE</option>
                <option value="2">DIÁRIA</option>
                <option value="3">NOTURNO</option>
                <option value="4">GARAGEM</option>
            </select>

            DIA DO PAGAMENTO: 
            <input type="tel" minlength="1" maxlength="2" size="2" id="diapagamento" name="diapagamento" required>

            <input class="btn btn-primary" type="submit" value="CADASTRAR"/>

        </form>

        <?php

        if($_SESSION['cliente'] == 1):
            echo "<hr><center><font size='6' color='#00a8ff'>Cliente cadastrado com sucesso</font></center>";
            $_SESSION['cliente'] = 3;
        elseif($_SESSION['cliente'] == 0):
            echo "<hr><center><font size='6' color='#cc3300'>Erro no cadastro/atualização</font></center>";
            $_SESSION['cliente'] = 3;
        elseif($_SESSION['cliente'] == 2):
                echo "<hr><center><font size='6' color='#00a8ff'>Atualização feita com sucesso</font></center>";
                $_SESSION['cliente'] = 3;
        endif;
        
    ?>

    </center>


    <hr><h1><center>Clientes Cadastrados</center></h1>

    <style>
      .myDiv {
                padding: 20px 50px;
                text-align: center; }
  	</style>


	<div class="myDiv">
	<table class="table table-hover">

    <tr>
            <th><b> ID </b></th>
            <th><b> CLIENTE </b></th>
            <th><b> CPF/CNPJ </b></th>
            <th><b> TELEFONE </b></th>
            <th><b> PLACA </b></th>
            <th><b> MARCA/MODELO </b></th>
            <th><b> TIPO DE VEÍCULO </b></th>
            <th><b> TIPO DE PLANO </b></th>
            <th><b> DIA DO PAGAMENTO </b></th>
            <th><b> PAGAMENTO </b></th>
            <th><b> EDITAR </b></th>
    </tr>

    <?php

    //Crud
    $listacliente = select_cliente($conexao);

    //Laço de repetição
    foreach ($listacliente as $cliente):

?>

    <tr>
    <td><?= $cliente['id_cliente'] ?></td>
    <td><?= $cliente['cliente']   ?></td>
    <td><?= $cliente['cpfcnpj']  ?></td>
    <td><?= $cliente['telefonecliente']  ?></td>
    <td><?= $cliente['placa']  ?></td>
    <td><?= $cliente['marcamodelo']  ?></td>
    <td><?= $cliente['tipoveiculo']  ?></td>
    <td><?= $cliente['plano']  ?></td>
    <td><?php if($cliente['diapagamento'] == 0): echo "**"; else: echo $cliente['diapagamento']; endif; ?></td>
    <td><?php if($cliente['plano'] != 'Cliente Frequente'): ?><a class = "btn btn-danger" 
        href ="pagamentocliente.php?idcliente=<?= $cliente['id_cliente'] ?>">Pagamento</a> <?php else: echo "****"; endif ?></td>
    <td><a class = "btn btn-info" href = "form-editarcliente.php?idcliente=<?=$cliente['id_cliente']?>">Editar</a></td>
   </tr>

<?php
    endforeach
?>
</table>

</div>

<?php 
    include ("footer-desktop.php");
?>