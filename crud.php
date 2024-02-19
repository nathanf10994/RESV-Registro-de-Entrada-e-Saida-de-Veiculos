<?php

session_start();

    // INDEX
     
        // Seleção de Usuário - Login
        function select_usuario($conexao, $login, $senha)
        {
            $query = "SELECT usuario.id_usuario, usuario.nome, usuario.login, usuario.senha, usuario.id_status, statususuario.status
                        FROM usuario INNER JOIN statususuario
                        ON usuario.id_status = statususuario.id_status
                        WHERE usuario.login = '{$login}'
                        AND usuario.senha = '{$senha}'";

            $resultado = mysqli_query($conexao, $query);
            $usuario = mysqli_fetch_assoc($resultado);

            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['status'] = $usuario['id_status'];
            $_SESSION['idusuario'] = $usuario['id_usuario'];
            $_SESSION['nomestatus'] = $usuario['status'];

            if($_SESSION['status']==3):
                header('Location:form-erro.php');
            else:
                return $usuario;
            endif;
        }
    
    
    // DESKTOP

        // Seleção de Veículos Estacionados
        function select_veiculosestacionados($conexao){
            
            $listaveiculos = array();

            $query = "SELECT esveiculos.id_estacionamento, tipoveiculo.tipoveiculo, 
            cobranca.cobranca, esveiculos.placa,esveiculos.marcamodelo, 
            esveiculos.telefone, esveiculos.dhentrada 
            FROM esveiculos INNER JOIN tipoveiculo
            ON esveiculos.id_tipoveiculo = tipoveiculo.id_tipoveiculo
            INNER JOIN cobranca
            ON esveiculos.id_cobranca = cobranca.id_cobranca
            WHERE dhsaida IS NULL
            ORDER BY esveiculos.id_estacionamento";

            $resultado = mysqli_query($conexao,$query);
            
            while($registroveiculo = mysqli_fetch_assoc($resultado))
            {
                array_push($listaveiculos,$registroveiculo);
            }

            return $listaveiculos;
        } 

        // Vagas Disponíveis - Motocicletas
        function vagasmotos($conexao){
            
            $query= "SELECT vagasdisponiveis FROM tipoveiculo
                    WHERE id_tipoveiculo = 1";

            $resultado = mysqli_query($conexao, $query);
            $vaga= mysqli_fetch_assoc($resultado);

            $_SESSION['vagasmotos'] = $vaga['vagasdisponiveis'];

            echo "<b>".$vaga['vagasdisponiveis']."</b>";

        }

        // Vagas Disponíveis - Pequeno Porte
        function vagaspequeno($conexao){
            
            $query= "SELECT vagasdisponiveis FROM tipoveiculo
                    WHERE id_tipoveiculo = 2";

            $resultado = mysqli_query($conexao, $query);
            $vaga= mysqli_fetch_assoc($resultado);

            $_SESSION['vagaspequeno'] = $vaga['vagasdisponiveis'];

            echo "<b>".$vaga['vagasdisponiveis']."</b>";

        }

        // Vagas Disponíveis - Medio Porte
        function vagasmedio($conexao){
            
            $query= "SELECT vagasdisponiveis FROM tipoveiculo
                    WHERE id_tipoveiculo = 3";

            $resultado = mysqli_query($conexao, $query);
            $vaga= mysqli_fetch_assoc($resultado);

            $_SESSION['vagasmedio'] = $vaga['vagasdisponiveis'];

            echo "<b>".$vaga['vagasdisponiveis']."</b>";

        }

        // Vagas Disponíveis - Grande Porte
        function vagasgrande($conexao){
            
            $query= "SELECT vagasdisponiveis FROM tipoveiculo
                    WHERE id_tipoveiculo = 4";

            $resultado = mysqli_query($conexao, $query);
            $vaga= mysqli_fetch_assoc($resultado);

            $_SESSION['vagasgrande'] = $vaga['vagasdisponiveis'];

            echo "<b>".$vaga['vagasdisponiveis']."</b>";

        }

        // Entrada de veículo comum
        function entradaveiculocomum($conexao, $tipo, $cobranca, $placa, $veiculo, $telefone){

            $usuario=$_SESSION['idusuario'];

            if($tipo == 1):
                $contavaga=$_SESSION['vagasmotos'];
            elseif($tipo == 2):
                $contavaga=$_SESSION['vagaspequeno'];
            elseif($tipo == 3):
                $contavaga=$_SESSION['vagasmedio'];
            elseif($tipo == 4):
                $contavaga=$_SESSION['vagasgrande'];
            endif;
        
            if($contavaga == 0):
                return false;     
            else:
                $query= "CALL sp_entradaveiculocomum('$tipo', '$cobranca', '$placa', '$veiculo', '$telefone', '$usuario')";

                return mysqli_query($conexao, $query);

            endif;

        }

        // Entrada de veículo de Cliente
        function entradaveiculocliente($conexao, $idcliente, $cobranca){

            $usuario=$_SESSION['idusuario'];

            $querytv="SELECT id_tipoveiculo FROM cliente WHERE id_cliente = '$idcliente'";
            $resultadotv= mysqli_query($conexao, $querytv);
            $tipoveiculo = mysqli_fetch_assoc($resultadotv);
            $tipo = $tipoveiculo['id_tipoveiculo'];

            if($tipo == 1):
                $contavaga=$_SESSION['vagasmotos'];
            elseif($tipo == 2):
                $contavaga=$_SESSION['vagaspequeno'];
            elseif($tipo == 3):
                $contavaga=$_SESSION['vagasmedio'];
            elseif($tipo == 4):
                $contavaga=$_SESSION['vagasgrande'];
            endif;

            if($contavaga == 0):
                return false;     
            else:
                $query= "CALL sp_entradaveiculocliente('$idcliente', '$cobranca', '$usuario')";

                return mysqli_query($conexao, $query);
            endif;

        }

        // Saída de veículo
        function saidaveiculo($conexao, $idestacionamento){

            $query = "CALL sp_saidaveiculo('$idestacionamento')";

            return mysqli_query($conexao, $query);

        }

        // Valor Pagamento
        function valorpagamento($conexao, $idestacionamento){

            $query= "   SELECT pagamento.tipocobranca, pagamento.tempototal, pagamento.valor,
                        esveiculos.dhentrada, esveiculos.dhsaida
                        FROM pagamento INNER JOIN esveiculos
                        ON pagamento.id_estacionamento = esveiculos.id_estacionamento
                        WHERE pagamento.id_estacionamento = '$idestacionamento'";
            $resultado = mysqli_query($conexao, $query);
            $infopagamento =  mysqli_fetch_assoc($resultado);

            return $infopagamento;

        }

    // CLIENTES

        // Seleção de Clientes
        function select_cliente($conexao){
            
            $listacliente = array();

            $query = "SELECT cliente.id_cliente, cliente.cliente, 
            cliente.cpfcnpj, cliente.telefonecliente, cliente.placa , 
            cliente.marcamodelo, tipoveiculo.tipoveiculo, plano.plano,
            cliente.diapagamento 
            FROM cliente INNER JOIN tipoveiculo
            ON cliente.id_tipoveiculo = tipoveiculo.id_tipoveiculo
            INNER JOIN plano
            ON cliente.id_plano = plano.id_plano
            ORDER BY cliente.id_cliente;";

            $resultado = mysqli_query($conexao,$query);
            
            while($cliente = mysqli_fetch_assoc($resultado))
            {
                array_push($listacliente,$cliente);
            }

            return $listacliente;

        } 

        // Cadastrar Cliente

        function addcliente($conexao, $cliente, $cpfcnpj, $telefone, $placa, $marcamodelo, $idtipoveiculo, $idplano, $diapagamento){

            $query = "CALL sp_addcliente('$cliente', '$cpfcnpj', '$telefone', 
            '$placa', '$marcamodelo', '$idtipoveiculo', '$idplano', '$diapagamento')";

            return mysqli_query($conexao, $query);

        }

        //Editar Cliente 
        function select_update_cliente($conexao, $idcliente){

            $query = "SELECT * FROM cliente
                        where id_cliente = '$idcliente'";

            $resultado = mysqli_query($conexao, $query);
            return mysqli_fetch_assoc($resultado);

        }

        function editacliente($conexao, $idcliente, $cliente, $cpfcnpj, $telefone, $placa, $marcamodelo, $idtipoveiculo, $idplano, $diapagamento){

            $query = "CALL sp_editacliente('$idcliente', '$cliente', '$cpfcnpj', '$telefone', 
            '$placa', '$marcamodelo', '$idtipoveiculo', '$idplano', '$diapagamento')";
            
            return mysqli_query($conexao, $query);

        }

        // Pagamento Cliente
        function pagamentocliente($conexao, $idcliente){

            $query = "CALL sp_pagamentocliente('$idcliente')";

            return mysqli_query($conexao, $query);

        }

        function valorpagamentocliente($conexao, $idcliente){
            
            $query = "SELECT pagamento.id_pagamento, pagamento.datapagamento, plano.plano, plano.valorplano 
                        FROM pagamento  INNER JOIN  cliente
                            ON pagamento.id_cliente = cliente.id_cliente
                        INNER JOIN plano
                            ON plano.id_plano = cliente.id_plano
                        WHERE pagamento.id_cliente = '$idcliente' 
                        AND pagamento.id_pagamento = (SELECT MAX(pagamento.id_pagamento) FROM pagamento)";

            $resultado = mysqli_query($conexao, $query);

            $infopagcliente = mysqli_fetch_assoc($resultado);

            return $infopagcliente;       

        }

    // RELATÓRIO

        // Relatório Fluxo de Veículos
        function relatoriofluxo($conexao, $dhinicio, $dhfinal){
            
            $query= "SELECT COUNT(*) AS 'total' FROM  esveiculos
                    WHERE dhentrada BETWEEN '$dhinicio' AND '$dhfinal''23:59:59'";

            $resultado = mysqli_query($conexao, $query);
            $fluxo= mysqli_fetch_assoc($resultado);

            echo $fluxo['total'];

        }

        // Relatório Fluxo de Veículos
        function relatoriofaturamento($conexao, $dhinicio, $dhfinal){
            
            $query= "SELECT SUM(valor) AS 'total' FROM pagamento
            WHERE datapagamento BETWEEN '$dhinicio' AND '$dhfinal'";

            $resultado = mysqli_query($conexao, $query);
            $faturamento= mysqli_fetch_assoc($resultado);

            echo $faturamento['total'];

        }

        //Histórico Fluxo Estacionamento
        function historicofluxo($conexao, $dhinicio, $dhfinal){

            $listahistorico = array();

            $query= "SELECT esveiculos.id_estacionamento, esveiculos.id_cliente, tipoveiculo.tipoveiculo, cobranca.cobranca, 
            esveiculos.placa, esveiculos.marcamodelo, esveiculos.dhentrada , esveiculos.dhsaida, usuario.nome
            FROM  esveiculos LEFT JOIN tipoveiculo
                ON esveiculos.id_tipoveiculo = tipoveiculo.id_tipoveiculo
            LEFT JOIN cobranca
                ON esveiculos.id_cobranca = cobranca.id_cobranca
            LEFT JOIN USUARIO
                ON esveiculos.id_usuario = usuario.id_usuario
            WHERE dhentrada BETWEEN '$dhinicio' AND '$dhfinal''23:59:59'
            ORDER BY esveiculos.dhentrada";

            $resultado=mysqli_query($conexao, $query);

            
            while($historico = mysqli_fetch_assoc($resultado))
            {
                array_push($listahistorico,$historico);
            }

            return $listahistorico;

        }

        //Histórico Faturamento
        function historicofaturamento($conexao, $dhinicio, $dhfinal){

            $listafaturamento = array();

            $query= "SELECT pagamento.id_pagamento, pagamento.id_estacionamento, pagamento.id_cliente, pagamento.tipocobranca, plano.plano,
            pagamento.tempototal, pagamento.valor, pagamento.datapagamento
            FROM  pagamento LEFT JOIN cliente
                ON pagamento.id_cliente = cliente.id_cliente
            LEFT JOIN plano
                ON cliente.id_plano = plano.id_plano
            WHERE datapagamento BETWEEN '$dhinicio' AND '$dhfinal'
            ORDER BY pagamento.datapagamento";

            $resultado=mysqli_query($conexao, $query);

            
            while($faturamento = mysqli_fetch_assoc($resultado))
            {
                array_push($listafaturamento,$faturamento);
            }

            return $listafaturamento;

        }

    // SETTINGS

        // Seleção de Usuários
        function select_user($conexao){
            
            $listausuario = array();

            $query = "SELECT usuario.id_usuario, statususuario.status, 
            usuario.nome, usuario.login 
            FROM usuario INNER JOIN statususuario
            WHERE usuario.id_status = statususuario.id_status
            ORDER BY id_usuario;";

            $resultado = mysqli_query($conexao,$query);
            
            while($usuario = mysqli_fetch_assoc($resultado))
            {
                array_push($listausuario,$usuario);
            }

            return $listausuario;

        } 

        // Cadastrar Usuario
        function addusuario($conexao, $status, $nome, $login, $senha){

            $query = "CALL sp_addusuario('$status', '$nome', '$login', '$senha')";

            return mysqli_query($conexao, $query);

        }

        // Editar Usuario
        function select_update_usuario($conexao, $idusuario){
            
            $query = "SELECT * FROM usuario
                        where id_usuario = '$idusuario'";

            $resultado = mysqli_query($conexao, $query);
            return mysqli_fetch_assoc($resultado);

        }

        function editausuario($conexao, $status, $idusuario, $nome, $login, $senha){

            $query = "CALL sp_editausuario('$idusuario', '$status', '$nome', '$login', '$senha')";

            return mysqli_query($conexao, $query);
            
        }


        // Seleção de Tipos de Veículo 
        function select_tipoveiculo($conexao){
            
            $listatipoveiculo = array();

            $query = "SELECT id_tipoveiculo, tipoveiculo, valorhora, 
            valorminuto, valordiaria, vagastotais 
            FROM tipoveiculo
            ORDER BY id_tipoveiculo;";

            $resultado = mysqli_query($conexao,$query);
            
            while($veiculo = mysqli_fetch_assoc($resultado))
            {
                array_push($listatipoveiculo,$veiculo);
            }

            return $listatipoveiculo;

        } 

        // Editar Tipo de Veículo
        function select_update_tipoveiculo($conexao, $idtipoveiculo){
            
            $query = "SELECT * FROM tipoveiculo
                        where id_tipoveiculo = '$idtipoveiculo'";

            $resultado = mysqli_query($conexao, $query);
            return mysqli_fetch_assoc($resultado);

        }

        function editatipoveiculo($conexao, $idtipoveiculo, $valorhora, $valorminuto, $valordiaria, $vagastotais){

            $query = "CALL sp_editatipoveiculo('$idtipoveiculo', '$valorhora', '$valorminuto', '$valordiaria', '$vagastotais')";

            return mysqli_query($conexao, $query);

        }

        // Seleção de Planos
        function select_plano($conexao){
            
            $listaplano = array();

            $query = "SELECT id_plano, plano, valorplano 
            FROM plano
            ORDER BY id_plano;";

            $resultado = mysqli_query($conexao,$query);
            
            while($plano = mysqli_fetch_assoc($resultado))
            {
                array_push($listaplano,$plano);
            }

            return $listaplano;

        } 

        // Editar Plano
        function select_update_plano($conexao, $idplano){
            
            $query = "SELECT * FROM plano
                        where id_plano = '$idplano'";

            $resultado = mysqli_query($conexao, $query);
            return mysqli_fetch_assoc($resultado);

        }

        function editaplano($conexao, $idplano, $valorplano){

            $query = "CALL sp_editaplano('$idplano', '$valorplano')";

            return mysqli_query($conexao, $query);

        }

?>