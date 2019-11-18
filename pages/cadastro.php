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
    
    $medicamento_selecionado = null;
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        $ch = curl_init("http://localhost:8080/produto/{$id}");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',
            "Authorization:Bearer " . $_SESSION['session_farma']                                                                               
        ));                                                             
                                                                                                                        
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);
        
        if($response->farmacia->id == $farmacia_logada->id){
            $medicamento_selecionado = $response;
        }
    }

    //Recuperando categorias
    $categorias = array();

    $ch = curl_init("http://localhost:8080/categoria");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                         
    ));                                                             
                                                                                                                    
    $response = curl_exec($ch);
    curl_close($ch);

    $categorias = json_decode($response);
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
                                <i><img src="../assets/img/add.png" alt="" srcset=""></i>
                                <span class="hidden-xs hidden-sm"><?php echo($medicamento_selecionado ? 'Alterar' : 'Adicionar');?></span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php">
                                <i><img src="../assets/img/list.png" alt="" srcset=""></i>
                                <span class="hidden-xs hidden-sm">Medicamentos</span>
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
                            <h3><?php echo ($medicamento_selecionado ? 'Alterar Medicamento' : 'Novo Medicamento');?></h3>
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
                                                    <a href="farmacia.php" style="color:#333">Minha Conta</a>
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
                <div class="row col-md-12 col-md-offset-2 custyle" style="margin: 0; padding: 100px 0">
                    <form 
                    class="col-md-8 col-md-offset-2" 
                    action="<?php echo ($medicamento_selecionado ?  '../atualizar_medicamento.php' : '../cadastrar_medicamento.php');?>" 
                    method="post"
                    enctype="multipart/form-data">
                        <input type="text" name="id" value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->id : '');?>" hidden>
                        <div class="form-group">
                            <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->nome : '');?>" class="form-control" type="text" placeholder="Nome do medicamento" name="nome" required>
                        </div>
                        <div class="form-group">
                            <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->principioAtivo : '');?>" class="form-control" type="text" placeholder="Princípio Ativo" name="principio_ativo">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->registroAnvisa : '');?>" class="form-control" type="number" placeholder="Registro Anvisa" name="registro_anvisa">
                            </div>
                            <div class="col-sm-6">
                                <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->detentorRegistro : '');?>" class="form-control" type="text" placeholder="Detentor Registro" name="detentor_registro">
                            </div>
                        </div><br>
                        <div class="form-group">
                            <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->concentracao : '');?>" class="form-control" type="text" placeholder="Concentração" name="concentracao">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->preco : '');?>" class="form-control" type="number" placeholder="Preço" name="preco">
                            </div>
                            <div class="col-sm-6">
                                <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->quantidade : '');?>" class="form-control" type="number" placeholder="Quantidade" name="quantidade">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="#categoria">Categorias</label>
                                <select id="categoria" class="form-control" name="categoria[]" multiple required>
                                    <option disabled>Selecione...</option>
                                    <?php foreach($categorias as $categoria): ?>
                                
                                        <option value="<?php echo $categoria->id;?>"><?php echo $categoria->nome;?></option>
                                    
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <input value="<?php echo ($medicamento_selecionado ? $medicamento_selecionado->formaFarmaceutica : '');?>" class="form-control" type="text" placeholder="Forma Farmaceutica" name="forma_farmaceutica">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Imagem</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="imagem">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" value="Salvar" class="btn btn-primary btn-block">
                            </div>
                            <div class="col-md-6">
                                <input type="reset" value="Limpar" class="btn btn-default btn-block">
                            </div>
                        </div>
                      
                    </form>
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