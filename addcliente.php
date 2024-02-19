<?php
  
    include ("connection-MySql.php");
    include ("crud.php");

    $cliente = $_POST['cliente'];
    $cpfcnpj = $_POST['cpfcnpj'];
    $telefone = $_POST['telefone'];
    $placa = $_POST['placa'];
    $marcamodelo = $_POST['marcamodelo'];
    $idtipoveiculo = $_POST['veiculo'];
    $idplano = $_POST['plano'];
    $diapagamento = $_POST['diapagamento'];


    if(addcliente($conexao, $cliente, $cpfcnpj, $telefone, $placa, $marcamodelo, $idtipoveiculo, $idplano, $diapagamento) == true):
        $_SESSION['cliente'] = 1;  
        header('Location:form-clientes.php');
    else:
        $_SESSION['cliente'] = 0;
        header('Location:form-clientes.php');
    endif;

?>

