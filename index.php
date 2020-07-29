<?php
	require_once("classes/person.php");
    /* Parâmetros da classe PDO
    Host: "localhost"
    DB Name: "crud_system"
    Username: "user"
    Password: "test_user" */
	$person = new Person("localhost", "crud_system", "user", "test_user");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alexys Santiago">
    <meta name="description" content="CRUD em PHP com classe PDO">
    <meta name="keywords" content="programação, MySQL, PHP, CRUD">
    <meta name="reply-to" content="SuxPorT@hotmail.com">
    <meta name="robots" content="index, follow">
    <meta http-equiv="content-language" content="pt-br">
	<title>CRUD - Cadastro de Pessoas</title>
	<link rel="icon" type="image/png" href="./images/icon.png">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<?php
		if (isset($_POST["name"])) {
			// Editar dados
			if (isset($_GET["id_update"]) && !empty($_GET["id_update"])) {
				$id_update = addslashes($_GET["id_update"]);
				$name = addslashes($_POST["name"]);
				$phone = addslashes($_POST["phone"]);
				$email = addslashes($_POST["email"]);

				if (!empty($name) && !empty($phone) && !empty($email)) {
					// Editar
					$person->updateData($id_update, $name, $phone, $email);

					header("location: index.php");
				}
				else {
	?>
					<div class="warning">
						<img src="./images/warning.png">
						<h4>Preencha todos os campos</h4>
					</div>
	<?php
				}
			}
			// Cadastrar dados
			else {
				$name = addslashes($_POST["name"]);
				$phone = addslashes($_POST["phone"]);
				$email = addslashes($_POST["email"]);

				if (!empty($name) && !empty($phone) && !empty($email)) {
					// Cadastrar
					if (!$person->registerPerson($name, $phone, $email)) {
	?>
						<div class="warning">
							<img src="./images/warning.png">
							<h4>Email já está cadastrado!</h4>
						</div>
	<?php
					}
				}
				else {
	?>
					<div class="warning">
						<img src="./images/warning.png">
						<h4>Preencha todos os campos</h4>
					</div>
	<?php
				}
			}

		}
	?>
	<?php
		if (isset($_GET["id_update"])) {
			$id_update = addslashes($_GET["id_update"]);
			$result = $person->fetchPersonData($id_update);
		}
	?>
		<section id="left">
			<form method="POST" action="">
				<h2>Cadastrar pessoa</h2>
				<label for="name">Nome</label>
				<input type="text" name="name" id="name" value="<?php if (isset($result)) { echo $result["name"]; } ?>">

				<label for="phone">Telefone</label>
				<input type="text" name="phone" id="phone" value="<?php if (isset($result)) { echo $result["phone"]; } ?>">

				<label for="email">Email</label>
				<input type="text" name="email" id="email" value="<?php if (isset($result)) { echo $result["email"]; } ?>">

				<input type="submit" value="<?php if (isset($result)) { echo "Atualizar"; } else { echo "Cadastrar"; } ?>">
			</form>
		</section>

		<section id="right">
			<table>
				<tr id="title">
					<th>Name</td>
					<th>Telefone</td>
					<th colspan="2">Email</td>
				</tr>
	<?php
			$data = $person->fetchData();

			// Há registros no Banco de Dados
			if (count($data) > 0) {
				for ($i = 0; $i < count($data); $i++) {
					echo "<tr>";

					foreach ($data[$i] as $key => $value) {
						if ($key != "id") {
							echo "<td>" . $value ."</td>";
						}
					}
	?>
					<td>
					    <a href="index.php?id_update=<?php echo $data[$i]["id"]; ?>">Editar</a>
					    <a href="index.php?id=<?php echo $data[$i]["id"]; ?>">Excluir</a>
					</td>
	<?php
					echo "</tr>";
				}
			}
			// O Banco de Dados está vázio
			else {
	?>
			</table>
				<div class="warning">
					<h4>Ainda não há pessoas cadastradas!</h4>
				</div>
	<?php
			}
	?>
	</section>
</body>
</html>
<?php
	if (isset($_GET["id"])) {
		$id_person = addslashes($_GET["id"]);
		$person->deletePerson($id_person);

		header("location: index.php");
	}
?>