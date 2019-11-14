<?php
    session_start();

    if(!isset($_SESSION['session_farma'])) {
        header('Location: login.php');
        exit;
    }

    // Recuperando dados do usuário logado
    $ch = curl_init('http://localhost:8080/administrador/administrador');
    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',
        "Authorization:Bearer " . $_SESSION['session_farma']                                                                                
    ));                                                             
                                                                                                                    
    $response = curl_exec($ch);
    curl_close($ch);

    // Convertendo json para objeto
    $farmacia_logada = json_decode($response);
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Área administrativa</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="../assets/css/styleAdmin.css" rel="stylesheet">
    
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="../assets/js/styleAdmin.js"></script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a hef="admin.html">
                        <img src="https://consultaremedios.com.br/assets/logos/logo_default-17ab6834258c29870f364a777d12cca917f79ff88aceb6b9c4f3b89ac8c0a53f.svg" alt="merkery_logo" class="hidden-xs hidden-sm">
                        <img src="https://consultaremedios.com.br/assets/logos/logo_default-17ab6834258c29870f364a777d12cca917f79ff88aceb6b9c4f3b89ac8c0a53f.svg" alt="merkery_logo" class="visible-xs visible-sm circle-logo">
                    </a>
                </div>
                <div class="navi">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i><img src="../assets/img/list.png" alt="" srcset=""></i>
                                <span class="hidden-xs hidden-sm">Medicamentos</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i><img src="../assets/img/add.png" alt="" srcset=""></i>
                                <span class="hidden-xs hidden-sm">Adicionar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
                <div class="row">
                    <header>
                        <div class="col-md-7">
                            <nav class="navbar-default pull-left">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                            <!-- Titulo da pagina -->
                            <h3>Minha Conta</h3>
                        </div>
                        <div class="col-md-5">
                            <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="../assets/img/user-icon.png" alt="user">
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span><?php echo $farmacia_logada->nome;?></span>
                                                    <a href="#" style="color:#333">Minha Conta</a>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="../sair.php" class="btn btn-sm btn-block btn-primary active">Sair</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                </div>

                <!-- Conteudo da página -->
                <div class="row" 
                style="
                    padding: 20px 100px;
                ">
                    <h4>Informações sobre a farmacia</h4>
                    <hr/>
                    <form action="../cadastrar_farmacia.php" method="post" role="form" style="
                        width: 100%;
                    ">

                        <label>Dados da farmácia </label>
                        <div class="form-group">
                            <input type="text" name="nome" id="nome" tabindex="1" class="form-control" placeholder="Nome" value="<?php echo $farmacia_logada->nome ;?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" onkeyup="mascara('##.###.###/####-##',this,event,true)" maxlength="18" value="<?php echo $farmacia_logada->cnpj ;?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="telefone" id="telefone" tabindex="1" class="form-control" placeholder="Telefone" value="<?php echo $farmacia_logada->telefone ;?>" required onkeyup="mascara('(##) ####-####',this,event,true)" maxlength="14">
                        </div>
                        <br>

                        <label>Endereço da farmácia</label>
                        <div class="form-group">
                            <input type="text" name="rua" id="rua" tabindex="1" class="form-control" placeholder="Rua" value="<?php echo $farmacia_logada->endereco->rua ;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="numero" id="numero" tabindex="1" class="form-control" placeholder="Nº" value="<?php echo $farmacia_logada->endereco->numero ;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="bairro" id="bairro" tabindex="1" class="form-control" placeholder="Bairro" value="<?php echo $farmacia_logada->endereco->setor ;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="latitude" id="latitude" tabindex="1" class="form-control" placeholder="Latitude" value="<?php echo $farmacia_logada->endereco->latitude ;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="longitude" id="longitude" tabindex="1" class="form-control" placeholder="Longitude" value="<?php echo $farmacia_logada->endereco->longitude ;?>" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-primary" value="Salvar Alterações" style="display:none">
                                </div>
                            </div>
                        </div>
                    </form>

                    <h4>Configurações Adicionais</h4>
                    <hr/>
                    <h5 style="font-weight:bold">Editar Conta</h5>
                    <p>Para habilitar a edição dos dados da farmacia, sigua o passo a baixo.</p>
                    <p class="alert alert-info" role="alert" style="display:flex;justify-content:space-between">
                        Para habilitar a alteração click em "Alterar"
                        <button style="background:#FFF;
                        border:0; border-radius:4px;">Alterar</button>
                    </p>
                    <hr/>
                    <h5 style="font-weight:bold">Encerrar Conta</h5>
                    <p>
                        Atenção, ao realizar este passo você perdera acesso imediato a sua conta bem como a todos os produtos já cadastrados.
                         Se mesmo assim deseja proceguir sigua o passo abaixo.
                    </p>
                    <p class="alert alert-danger" role="alert" style="display:flex;justify-content:space-between">
                        Para excluir sua conta click em "Delete"
                        <button style="background:#FFF;
                        border:0; border-radius:4px;">Delete</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
             
    
    <!-- Modal exclusao de elementos -->
    <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Esta ação requer confirmação</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Deseja realmente excluir o item <span id="nome-medicamento"></span></p>
        </div>
        <div class="modal-footer">
            <a id="confirmar-exclusao" href="#" class="btn btn-primary">Confirmar</a>
            <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
        </div>
        </div>
    </div>
    </div>
   
</body>
</html>