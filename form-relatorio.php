<?php

    include ("connection-MySql.php");
    include ("crud.php");

    $_SESSION['page'] = 3;

    include ("header-desktop.php");

    if($_SESSION['login'] != true):
        header('Location:form-erro.php');
    endif;

    if($_SESSION['status'] != 1):
        header('Location:form-acesso-negado.php');
    endif;

?>
        
     
        <br><br><br>
        <center>
        <form action= <?php echo $_SERVER['PHP_SELF']?> method="post">

                Data/Hora Inicial:
            <input type="date" id="dhinicio" name="dhinicio" required>
                Data/Hora Final:
            <input type="date" id="dhfinal" name="dhfinal" required>
            <br><br>
            <input class="btn btn-primary" type="submit" name="entrar" value="Gerar Relatórios"/>
        </form>
        </center>

    

<?php

    if(isset($_POST['entrar'])):

    $dhinicio= $_POST['dhinicio'];
    $dhfinal = $_POST['dhfinal'];

?>

    <center><br><br><h1>Histórico do Período: <?=$dhinicio ?> a <?=$dhfinal ?> </h1></center>

    <style>
        .myDiv {
            padding: 50px 500px;
            text-align: left;
            }
    </style>

    <div class="myDiv">
    <table class = "table">

        <tr>
            <th><font size="4">Fluxo de Veículos:</th>
            <td><font size="4" color="#00a8ff"><?php relatoriofluxo($conexao, $dhinicio, $dhfinal) ?></td>
        </tr>
        <tr>
            <th><font size="4">Faturamento Total:</th>
            <td><font size="4" color="#00a8ff">R$ <?php relatoriofaturamento($conexao, $dhinicio, $dhfinal) ?></td><tr>

    </table>
    </div>

    <style>
        .myDiv2 {
            padding: 20px 50px;
            text-align: center;
            }
    </style>

    <div class="myDiv2">

    <center><h2> Movimentação </h2></center>
    <br>
        <table class="table table-hover">

            <tr>
                    <th><b> ID ESTACIONAMENTO</b></th>
                    <th><b> ID CLIENTE</b></th>
                    <th><b> TIPO DE VEÍCULO </b></th>
                    <th><b> TIPO DE COBRANCA </b></th>
                    <th><b> PLACA </b></th>
                    <th><b> MARCA/MODELO </b></th>
                    <th><b> D/H ENTRADA </b></th>
                    <th><b> D/H SAÍDA </b></th>
                    <th><b> USUÁRIO </b></th>

            </tr>


<?php
    
    $listahistorico = historicofluxo($conexao, $dhinicio, $dhfinal);

    foreach ($listahistorico as $historico):

?>

    <tr>
    <td><?= $historico['id_estacionamento'] ?></td>
    <td><?php if($historico['id_cliente'] == null): echo "****"; else: echo $historico['id_cliente']; endif;  ?></td>
    <td><?= $historico['tipoveiculo']  ?></td>
    <td><?= $historico['cobranca']  ?></td>
    <td><?= $historico['placa']  ?></td>
    <td><?= $historico['marcamodelo']  ?></td>
    <td><?= $historico['dhentrada']  ?></td>
    <td><?= $historico['dhsaida']  ?></td>
    <td><?= $historico['nome']  ?></td>
   </tr>

<?php
    endforeach
?>
    </table>
    </div>

    <div class="myDiv2">

    <center><h2> Faturamento </h2></center>
    <br>
        <table class="table table-hover">

            <tr>
                    <th><b> ID PAGAMENTO</b></th>
                    <th><b> ID ESTACIONAMENTO</b></th>
                    <th><b> ID CLIENTE</b></th>
                    <th><b> TIPO DE COBRANCA </b></th>
                    <th><b> PLANO </b></th>
                    <th><b> TEMPO TOTAL </b></th>
                    <th><b> VALOR </b></th>
                    <th><b> DATA PAGAMENTO </b></th>

            </tr>


<?php
    
    $listafaturamento = historicofaturamento($conexao, $dhinicio, $dhfinal);

    foreach ($listafaturamento as $faturamento):

?>

    <tr>
    <td><?= $faturamento['id_pagamento'] ?></td>
    <td><?php if($faturamento['id_estacionamento'] == null): echo "****"; else: echo $faturamento['id_estacionamento']; endif;  ?></td>
    <td><?php if($faturamento['id_cliente'] == null): echo "****"; else: echo $faturamento['id_cliente']; endif;  ?></td>
    <td><?= $faturamento['tipocobranca']  ?></td>
    <td><?php if($faturamento['plano'] == null): echo "****"; else: echo $faturamento['plano']; endif;  ?></td>
    <td><?php if($faturamento['tempototal'] == null): echo "****"; else: echo $faturamento['tempototal']; endif;  ?></td>
    <td>R$ <?= $faturamento['valor']  ?></td>
    <td><?= $faturamento['datapagamento']  ?></td>
   </tr>

<?php
    endforeach
?>
    </table>
    </div>
        

        <center>
            <a class="btn btn-primary" href="desktop.php">Voltar ao Home</a>
        </center>

    
<?php 

    endif;

    include ("footer-desktop.php");
?>
