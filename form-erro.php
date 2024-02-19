<!DOCTYPE html>
<html lang='pt-br'>
    <head> 
        <meta charset="utf-8">
        <title> Erro de Login - RESV </title>
        <link rel = "shortcut icon" href = "image/logo.ico">
        <link rel = "stylesheet" href ="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
        <body>
        <center><br><br><br><br><br><br><br><img src="PNG/resv.png" width = "400"><br>
            <center><h3><br><p class="text-danger">Acesso Negado</font></p></h3>
            <div>
                 <form action="index.php" method="post">
                        <br>
                        <label for="login">Login:</label><br>
                        <input type="text" id="login" name="login"  required><br>
                        <label for="senha">Senha:</label><br>
                        <input type="password" id="senha" name="senha"  required><br><br>
                        <input type="submit" value="Entrar">
                      </form>
            </div>
        </center>