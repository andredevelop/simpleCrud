<?php 
	//conexão com banco de dados
	$pdo = new PDO("mysql:host=localhost;dbname=crud","root","");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<h2>Cadastro de livros</h2>
	</header>

	<section class="main">

		<div class="center">
			<h2>Adicione um livro à sua lista!</h2>
			<form method="post">
				<?php 
				//inserindo dados ao banco de dados
					if(isset($_POST['cadastrar'])){
						$livro = $_POST['nome_livro'];
						$conteudo = $_POST['conteudo_livro'];

						if($livro == '' || $conteudo == ''){
							echo '<script>alert("Os campos não podem estar vazios!")</script>';
						}else{
							$cad = $pdo->prepare("INSERT INTO `livros` VALUES (null,?,?)");
							if($cad->execute(array($livro,$conteudo))){
								header('Location:index.php');
							}
						}
					}	

				?>

				<div class="input-wraper">
					<span>Nome do livro:</span>
					<input type="text" name="nome_livro" placeholder="Nome do seu livro...">
				</div><!-- input-wraper -->

				<div class="input-wraper">
					<span>Escreva o conteúdo:</span>
					<textarea name="conteudo_livro" placeholder="Escreva seu livro aqui..."></textarea>
				</div><!-- input-wraper -->

				<input type="submit" name="cadastrar" value="Cadastrar">
			</form><!-- form -->
		</div><!-- center -->

		<section class="listLivro">

			<div class="center">
				<h2>Lista de livros escritos</h2>
				
				<div class="table">

					<div class="titleTab">
						<div class="cell">N°</div><!-- cell -->
						<div class="cell">Nome</div><!-- cell -->
						<div class="cell">Conteúdo</div><!-- cell -->
						<div class="cell">#</div><!-- cell -->
						<div class="cell">#</div><!-- cell -->
					</div><!-- row -->

					<div class="tabBody">
						
						<?php
							//deletando via requisição GET
							//depois de deletar aparece um aviso, e volta a pagina inicial
							if(isset($_GET['deletar'])){
								$id = $_GET['deletar'][0];
								$deletar = $pdo->prepare("DELETE FROM `livros` WHERE id = ?");
								if($deletar->execute(array($id))){
									echo '<script>alert("Livro deletado com sucesso!")</script>';
									header('Location:index.php');
								}
							}


							//lendo registros no banco de dados e mostrando
							//em uma lista
							$show = $pdo->prepare("SELECT * FROM `livros`");
							$show->execute();

							foreach ($show as $key => $value) {
						?>

						<div class="row">
							<div class="cell"><?php echo $key+1 ?>°</div><!-- cell -->
							<div class="cell"><?php echo mb_substr($value['nome_livro'],0, 10); ?>...</div><!-- cell -->
							<div class="cell"><?php echo mb_substr($value['conteudo'], 0, 10); ?>...</div><!-- cell -->
							<div class="cell"><a href="editar-livro.php?id=<?php echo $value['id']; ?>">Editar</a></div><!-- cell -->
							<div class="cell"><a class="del" href="?deletar=<?php echo $value['id']; ?>">Deletar</a></div><!-- cell -->
						</div><!-- row -->
						<?php } ?>
						
					</div><!-- tabbody -->
				</div><!-- table -->

			</div><!-- center -->
			
		</section><!-- lista livro -->
	</section><!-- main -->

	
</body>
</html>