<?php

include ("connection-MySql.php");
include ("crud.php");

$idestacionamento= $_GET['idestacionamento'];
$cobranca = $_GET['cobranca'];

$_SESSION['idestacionamento']= $idestacionamento;

saidaveiculo($conexao, $idestacionamento);

    if($cobranca == 'Mensalista'):
        header('Location:form-mensalista.php');
    else:
        header('Location:form-pagamento.php');
    endif;

?>