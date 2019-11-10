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
    
    // Buscar todos os medicamentos para listagem
    require_once '../buscar_medicamentos.php';
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
                        <li class="active">
                            <a href="#">
                                <i class="fas fa-angle-right"></i>
                                <span class="hidden-xs hidden-sm">Cadastrar</span>
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

                            <!-- Campo de busca -->
                            <div class="search hidden-sm">
                                <form method="get">
                                    <button type="submit"><img src="../assets/img/search.png" alt=""></button>
                                    <input type="text" placeholder="Buscar Medicamento" name="busca" id="search">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Adicionar Medicamento</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="../assets/img/user-icon.png" alt="user">
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span><?php echo $farmacia_logada->nome;?></span>
                                                    <a href="#" style="color:#333">Editar perfil</a>
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
                <div class="row" style="padding-top: 10px;">
                    <div class="container">
                        <p class="alert alert-success" role="alert" <?php echo (isset($_GET['i']) && $_GET['i'] == 's1' ? '' : 'style="display:none"'); ?>>
                            Medicamento cadastrado com sucesso!
                            <button id="close-success">X</button>
                        </p>
                        <p  class="alert alert-danger" role="alert" <?php echo (isset($_GET['i']) && $_GET['i'] == 'e1' ? '' : 'style="display:none"'); ?>>
                            Sinto muito, mas não foi possível cadastra o medicamento :(
                            <button id="close-error">X</button>
                        </p>
                        <div class="row col-md-12 col-md-offset-2 custyle" style="margin: 0">
                            <table class="table table-striped table-responsible custab">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Forma Farmaceutica</th>
                                        <th>Preço</th>
                                        <th>Quantidade</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($medicamentos as $medicamento): ?>
                                    <tr>
                                        <td><?php echo $medicamento->id; ?></td>
                                        <td><?php echo $medicamento->nome; ?></td>
                                        <td><?php echo $medicamento->formaFarmaceutica; ?></td>
                                        <td><?php echo $medicamento->preco; ?></td>
                                        <td><?php echo $medicamento->quantidade; ?></td>
                                        <td class="text-center">
                                            <a class='btn btn-primary btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Editar</a> 
                                            <a href="../deletar_medicamento.php?id=<?php echo $medicamento->id; ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Deletar</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="add_project" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar Medicamento</h4>
                </div>
                <form action="../cadastrar_medicamento.php" method="post">
                    <div class="modal-body">
                        <input type="text" placeholder="Nome do medicamento" name="nome" required>
                        <input type="text" placeholder="Princípio Ativo" name="principio_ativo">
                        <input type="text" placeholder="Concentração" name="concentracao">
                        <input type="text" placeholder="Forma Farmaceutica" name="forma_farmaceutica">
                        <input type="number" placeholder="Registro Anvisa" name="registro_anvisa">
                        <input type="text" placeholder="Detentor Registro" name="detentor_registro">
                        <input type="number" placeholder="Preço" name="preco">
                        <input type="number" placeholder="Quantidade" name="quantidade">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="add-project">Salvar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('close-success').addEventListener('click', function(){
            document.querySelector('.container .alert-success').setAttribute('style', 'display:none');
            window.location = document.URL.replace('?i=s1', '');
        });

        document.getElementById('close-error').addEventListener('click', function(){
            document.querySelector('.container .alert-danger').setAttribute('style', 'display:none');
            window.location = document.URL.replace('?i=e1', '');
        });
    </script>
</body>
</html>