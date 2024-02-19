<?php

    include ("connection-MySql.php");
    include ("crud.php");
    include ("header-desktop.php");

    $idcliente = $_GET['idcliente'];

    $infocliente = select_update_cliente($conexao, $idcliente);

?>

    <style>
      .myDiv {
                padding: 0px 600px;
                text-align: left; } 
    </style>
	<div class="myDiv">

        <br><br><h1><center>Editar Cliente</center></h1><br>

        <form action="editarcliente.php" method="post">

            <div>
            ID CLIENTE:
            <input type="tel" class="form-control" size="5" id="idcliente" name="idcliente" value="<?= $infocliente['id_cliente'] ?>" readonly>
            </div>

            <div>
            NOME DO CLIENTE: 
            <input type="text" class="form-control" maxlength="30" size="30" id="cliente" name="cliente" value="<?= $infocliente['cliente'] ?>" required>
            CPF/CNPJ: 
            <input type="tel" class="form-control" minlength="11" maxlength="14" size="14" id="cpfcnpj" name="cpfcnpj" value="<?= $infocliente['cpfcnpj'] ?>" required>
            </div>

            <div>
            TELEFONE: 
            <input type="tel" class="form-control" minlength="10" maxlength="11" size="11" id="telefone" name="telefone" value="<?= $infocliente['telefonecliente'] ?>" required>
            </div>

            <div>
            PLACA: 
            <input type="text" class="form-control" minlength="7" maxlength="7" size="7" id="placa" name="placa" value="<?= $infocliente['placa'] ?>" required>
            </div>

            <div>
            MARCA/MODELO:  
            <input type="text" class="form-control" maxlength="30" size="30" id="marcamodelo" name="marcamodelo" value="<?= $infocliente['marcamodelo'] ?>" required>
            </div>

            <div>
            TIPO DE VEÍCULO: 
            <select id="veiculo" class="dropdown-item" name="veiculo" required>
                <option></option>
                <option value="1">MOTOCICLETA</option>
                <option value="2">PEQUENO PORTE</option>
                <option value="3">MEDIO PORTE</option>
                <option value="4">GRANDE PORTE</option>
            </select>
            </div>

            <div>
            PLANO: 
            <select id="plano" class="dropdown-item" name="plano" required>
                <option></option>
                <option value="1">CLIENTE FREQUENTE</option>
                <option value="2">DIÁRIA</option>
                <option value="3">NOTURNO</option>
                <option value="4">GARAGEM</option>
            </select>
            </div>

            <div>
            DIA DO PAGAMENTO: 
            <input type="tel" class="form-control" minlength="1" maxlength="2" size="2" id="diapagamento" name="diapagamento" value="<?= $infocliente['diapagamento'] ?>"required>
            </div>

            <br><center>
            <input class="btn btn-primary" type="submit" value="Atualizar"/>
            <a class="btn btn-danger" type="submit" href="form-clientes.php">Voltar</a>
            </center>
            
        </form>

      </div>

<?php 
    include ("footer-desktop.php");
?>