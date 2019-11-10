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
                                <span class="hidden-xs hidden-sm">Medicamentos</span>
                            </a>
                        </li>
                        <li>
                            <a href="cadastro.php">
                                <i class="fas fa-angle-right"></i>
                                <span class="hidden-xs hidden-sm">Novo Medicamento</span>
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

                            <!-- Campo de busca
                            <div class="search hidden-sm">
                                <form method="get">
                                    <button type="submit"><img src="../assets/img/search.png" alt=""></button>
                                    <input type="text" placeholder="Buscar Medicamento" name="busca" id="search">
                                </form>
                            </div> -->
                            <h3>Todos os medicamentos</h3>
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
                        <p class="alert alert-info" role="alert" <?php echo (isset($_GET['i']) && $_GET['i'] == 's2' ? '' : 'style="display:none"'); ?>>
                            Medicamento excluido com sucesso!
                            <button id="close-success2">X</button>
                        </p>
                        <p  class="alert alert-danger" role="alert" <?php echo (isset($_GET['i']) && $_GET['i'] == 'e1' ? '' : 'style="display:none"'); ?>>
                            Sinto muito, mas não foi possível cadastra o medicamento :(
                            <button id="close-error">X</button>
                        </p>
                        <p  class="alert alert-danger 2" role="alert" <?php echo (isset($_GET['i']) && $_GET['i'] == 'e2' ? '' : 'style="display:none"'); ?>>
                            Sinto muito, mas não foi possível excluir o medicamento :(
                            <button id="close-error2">X</button>
                        </p>
                        <div class="row col-md-12 col-md-offset-2 custyle" style="margin: 0">
                            <table class="table table-striped table-responsible custab">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
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
                                        <td>
                                            <?php 
                                                if(isset($medicamento->imagens[0]->id)) {
                                                    $id = $medicamento->imagens[0]->id;
                                                    ?>
                                                    <img src="http://localhost:8080/imagem/<?php echo $id;?>" width="50px">
                                                    <?php
                                                } else { 
                                                    ?>
                                                    <img src="../assets/img/default.jpg" width="50px">
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $medicamento->nome; ?></td>
                                        <td><?php echo $medicamento->formaFarmaceutica; ?></td>
                                        <td><?php echo $medicamento->preco; ?></td>
                                        <td><?php echo $medicamento->quantidade; ?></td>
                                        <td class="text-center">
                                            <a class='btn btn-primary btn-xs' href="cadastro.php?id=<?php echo $medicamento->id;?>"><span class="glyphicon glyphicon-edit"></span> Editar</a> 
                                            <a 
                                                href="#"
                                                id="<?php echo $medicamento->id; ?>" 
                                                data-target="#exampleModal"
                                                value="<?php echo $medicamento->nome; ?>" 
                                                class="deletar btn btn-danger btn-xs"
                                                data-toggle="modal">
                                                    <span class="glyphicon glyphicon-remove"></span> Deletar</a>
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

    <script>

        // Fechando menssagem de medicamento cadastrado com sucesso
        document.getElementById('close-success').addEventListener('click', function(){
            window.location = document.URL.replace('?i=s1', '');
        });

        // Fechando menssagem de erro ao cadatrar medicamento
        document.getElementById('close-error').addEventListener('click', function(){
            window.location = document.URL.replace('?i=e1', '');
        });

        // Fechando menssagem de medicamento excluido com sucesso
        document.getElementById('close-success2').addEventListener('click', function(){
            window.location = document.URL.replace('?i=s2', '');
        });

        // Fechando menssagem de falha ao excluir medicamento
        document.getElementById('close-error2').addEventListener('click', function(){
            window.location = document.URL.replace('?i=e2', '');
        });

        const buttons = document.querySelectorAll('td .deletar');
        const nomeMedicamento = document.getElementById('nome-medicamento');
        const confirmar = document.getElementById('confirmar-exclusao');

        for(let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', function(e){
                
                let nome = buttons[i].getAttribute('value');
                let id =  buttons[i].getAttribute('id');

                nomeMedicamento.innerHTML = '"'+nome+'"';

                confirmar.setAttribute('href', `../excluir_medicamento.php?id=${id}`);
            });
        }
    </script>
</body>
</html>