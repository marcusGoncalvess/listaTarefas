<?php 
    require '../backend/tarefa.model.php';//O script tarefa controller será requisitado da pasta public
    require '../backend/tarefa.service.php';//Por isso aqui devemos colocar o endereço completo dos scripts protegidos
    require '../backend/conexao.php';
    
    $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;//Se existir no GET acao então $acao recebe o que estiver no get
    //                                                     Senão ação recebe ação(que foi definida em todas_tarefas.php)
    $pagina = basename($_SERVER['PHP_SELF'],'.php');
    $tarefa = new Tarefa();//instanciando o obj tarefa
    $conexao = new Conexao();//fazendo a conexao com o db
    if($acao == 'inserir'){
        $tarefa->__set('tarefa', $_POST['tarefa']);//Setar o attb tarefa com o attb recebido do form
        $tarefaService = new TarefaService($conexao,$tarefa);//tarefa services é onde o obj conexao e o obj tarefa se juntam para fazer as alterações no banco de dados
        $tarefaService->inserir();//Inserindo no banco de dados a tarefa
        header('Location: nova_tarefa.php?inclusao=1');
    } else if($acao == 'recuperar'){
        //Pegando todas tarefas do DB para listar na pagina
        $tarefaService = new TarefaService($conexao,$tarefa);
        $tarefasRecuperadas = $tarefaService->recuperar();
    } else if($acao == 'atualizar') {
        //Atualizando tarefas atráves de um form feito com JS dinamicamente
        $tarefa->__set('id',$_POST['id']);
        $tarefa->__set('tarefa',$_POST['tarefa']);
        $tarefaService = new TarefaService($conexao,$tarefa);
        if($tarefaService->atualizar()){
            header('location: '.$pagina.'.php');
        }
    } else if($acao == 'remover'){
        //Removendo a tarefa selecionada do DB
        $tarefa->__set('id',$_GET['id']);
        $tarefaService = new TarefaService($conexao,$tarefa);
        $tarefaService->remover();
        header('location: '.$pagina.'.php');
    } else if($acao == 'marcarRealizada'){
        $tarefa = new Tarefa();
        $tarefa->__set('id',$_GET['id']);
        $tarefa->__set('id_status',2);
        $tarefaService = new TarefaService($conexao,$tarefa);
        $tarefaService->marcarRealizada();
        header('location: '.$pagina.'.php');
    }
?>