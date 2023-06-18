<?php 
$pdo = new PDO("mysql:host=localhost;dbname=crud","root","");
	//pega o valor do id do livro que tem que ser editado
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'][0];

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
		<h2>Edição de livro</h2>
	</header>

	<section class="main">

		<div class="center">
			<h2>Adicione um livro à sua lista!</h2>
			<form method="post">
				<?php
					//atualizando editando
					//se existir o envio do botao atualizar
					if(isset($_POST['atualizar'])){
						$livro = $_POST['nome_livro'];
						$conteudo = $_POST['conteudo_livro'];

						if($livro == '' || $conteudo == ''){
							echo '<script>alert("Os campos não podem estar vazios!")</script>';
							header('Location:index.php');
						}else{
							$atualiza = $pdo->prepare("UPDATE `livros` SET nome_livro = ?, conteudo = ? WHERE id = ?");
							if($atualiza->execute(array($livro,$conteudo,$id))){
								//retorna a pagina inicial após conseguir executar a ação
								header('Location:index.php');
							}
						}
					}

					//retorna valores do livro que está sendo editado
					$show = $pdo->prepare("SELECT * FROM `livros` WHERE id = ?");
					$show->execute(array($id));
					foreach ($show as $key => $value) {
				?>
				<div class="input-wraper">
					<span>Nome do livro:</span>
					<input type="text" name="nome_livro" placeholder="Nome do seu livro..." value="<?php echo $value['nome_livro']; ?>">
				</div><!-- input-wraper -->

				<div class="input-wraper">
					<span>Escreva o conteúdo:</span>
					<textarea name="conteudo_livro" placeholder="Escreva seu livro aqui..."><?php echo $value['conteudo']; ?></textarea>
				</div><!-- input-wraper -->
				<?php } ?>

				<input type="submit" name="atualizar" value="atualizar">
			</form><!-- form -->
		</div><!-- center -->

	</section><!-- main -->

	
</body>
</html>
<?php } ?>