<?php
	$acao = 'recuperar';
	require 'tarefa_controller.php';

?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<script>
			function editar(id,textTarefa){
				/*
				Aqui vamos criar um form para aparecer quando o usuario querer editar a tarefa, esse form sera enviado para o banco de dados para alterar a tarefa lá tambem
				*/
				//Criando elements
				let form = document.createElement('form')
				form.method = 'post'
				form.action = 'index.php?acao=atualizar'
				form.className = 'row'

				let inputTarefa = document.createElement('input')
				inputTarefa.type = 'text'
				inputTarefa.name = 'tarefa'
				inputTarefa.className = 'col-9 form-control'
				inputTarefa.value = textTarefa

				let inputId = document.createElement('input')
				inputId.type = 'hidden'//esse input levara para o back-end o id correto para alterar no banco de dados
				inputId.name = 'id'
				inputId.value = id

				let button = document.createElement('button')
				button.type = 'submit'
				button.className = 'col-3 btn btn-info'
				button.innerHTML = 'Atualizar'
				//Colocando o input e o button dentro do form
				form.appendChild(inputTarefa)
				form.appendChild(button)
				form.appendChild(inputId)
				//--------------------------
				let tarefa = document.querySelector(`#tarefa_${id}`)//Selecionando a tarefa que foi acionada
				
				tarefa.innerHTML = ''//Limpando conteudo da tarefa
				tarefa.insertBefore(form,tarefa[0])//inserir o form criado acima no lugar da tarefa acionada
			}

			function remover(id){
				location.href = `index.php?acao=remover&id=${id}`;//Direcionando a pagina para essa URL, para trabalharmos com o PHP
			}
			
			function marcarRealizada(id){
				location.href = `index.php?acao=marcarRealizada&id=${id}`
			}
		</script>
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-md-3 menu">
					<ul class="list-group">
						<li class="list-group-item active"><a href="#">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item"><a href="todas_tarefas.php">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-md-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Tarefas pendentes</h4>
								<hr />
								<? foreach($tarefasRecuperadas as $indice => $tarefa) { ?>
									<? if($tarefa['status'] == 'pendente') { ?>
										<div class="row mb-3 d-flex align-items-center tarefa">
											<div id='tarefa_<?= $tarefa['id'] ?>' class="col-sm-9"><!--Colocando um ID individual para cada tarefa-->
												<?=($tarefa['tarefa'])?><!--Listando a tarefa e o Status da tarefa-->
											</div>
											<div class="col-sm-3 mt-2 d-flex justify-content-between">
												<i class="fas fa-trash-alt fa-lg text-danger" onclick='remover(<?= $tarefa["id"] ?>)'></i>
													<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa['id'] ?>,'<?= $tarefa['tarefa'] ?>')"></i>
													<i class="fas fa-check-square fa-lg text-success" onclick="marcarRealizada(<?= $tarefa['id'] ?>)"></i>
											</div>
										</div>
									<?}?>
								<?}?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>