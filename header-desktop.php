<!DOCTYPE html>
<html lang='pt-br'>
    <head> 
        <meta charset="utf-8">
        <title> RESV - Registro de Entrada e Saída de Veículos </title>
        <link rel = "shortcut icon" >
        <link rel = "stylesheet" href ="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
        <body>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00006f">
  <div class="container-fluid">
    <a class="navbar-brand" href="desktop.php"><img src="png/resv.png" width="150"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="desktop.php"><?php if($_SESSION['page'] == 1): ?><b><font color="white"><?php endif ?> HOME </b></font></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="form-clientes.php"><?php if($_SESSION['page'] == 2): ?><b><font color="white"><?php endif ?> CLIENTES </b></font></a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="form-relatorio.php"><?php if($_SESSION['page'] == 3): ?><b><font color="white"><?php endif ?> RELATÓRIO </b></font></a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="form-settings.php"><?php if($_SESSION['page'] == 4): ?><b><font color="white"><?php endif ?> SETTINGS </b></font></a>
        </li>
      </ul>
    </div>
      <div>
        <center>
            <font color="lightgray">Usuário: </font>
            <font color="white"><?php echo $_SESSION['nome']?></font>
            <font color="lightgray">     |     Status: </font>
            <font color="white"><?php echo $_SESSION['nomestatus']?></font>
        </center>
      </div>
        <li class="nav-item">
          <a class="btn btn-outline-light" aria-current="page" href="logout.php"> LOGOUT </a>
        </li>
  </div>
</nav>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>