<?php
session_start();
    if(!isset($_SESSION['nome']) && !isset($_SESSION['email'])){
        header('Location: login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="css/styleAdmin.css" rel="stylesheet">
    <script src="js/styleAdmin.js"></script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a hef="admin.html"><img src="https://consultaremedios.com.br/assets/logos/logo_default-17ab6834258c29870f364a777d12cca917f79ff88aceb6b9c4f3b89ac8c0a53f.svg" alt="merkery_logo" class="hidden-xs hidden-sm">
                        <img src="https://consultaremedios.com.br/assets/logos/logo_default-17ab6834258c29870f364a777d12cca917f79ff88aceb6b9c4f3b89ac8c0a53f.svg" alt="merkery_logo" class="visible-xs visible-sm circle-logo">
                    </a>
                </div>
                <div class="navi">
                    <ul>
                        <li class="active"><a href="#"><i class="fas fa-angle-right"></i><span class="hidden-xs hidden-sm">Cadastrar</span></a></li>
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
                            <div class="search hidden-xs hidden-sm">
                                <input type="text" placeholder="Buscar Medicamento" id="search">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Adicionar Medicamento</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="user-icon.png" alt="user">
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span>JS Krishna</span>
                                                    <p class="text-muted small">
                                                        me@jskrishna.com
                                                    </p>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="sair.php" class="view btn-sm active">Sair</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                </div>
                <div class="row" style="padding-top: 80px;">
                    <div class="container">
                        <div class="row col-md-6 col-md-offset-2 custyle">
                            <table class="table table-striped custab">
                                <thead>
                                    <a href="#" class="btn btn-primary btn-xs pull-right"><b>+</b> Add new categories</a>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Parent ID</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>1</td>
                                    <td>News</td>
                                    <td>News Cate</td>
                                    <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Products</td>
                                    <td>Main Products</td>
                                    <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Blogs</td>
                                    <td>Parent Blogs</td>
                                    <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
                                </tr>
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
                <div class="modal-body">
                    <input type="text" placeholder="Nome do medicamento" name="name">
                    <input type="number" placeholder="Preço" name="number">
                    <input type="number" placeholder="Quantidade" name="quantidade">
                    <input type="text" placeholder="Concentração" name="concentracao">
                    <input type="text" placeholder="Detentor Registro" name="detentorregistro">
                    <input type="text" placeholder="Forma Farmaceutica" name="formafarmaceutica">
                    <input type="text" placeholder="Princípio Ativo" name="principioativo">
                    <input type="number" placeholder="Registro Anvisa" name="registroanvisa">
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel" data-dismiss="modal">Fechar</button>
                    <button type="button" class="add-project" data-dismiss="modal">Salvar</button>
                </div>
            </div>

        </div>
    </div>

</body>

</html>