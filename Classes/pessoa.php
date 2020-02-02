<?php
class Pessoa {

	private $pdo;

	// Conexão com o Banco de Dados
	public function __construct($host, $dbname, $user, $senha) {
		try {
			$this->pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $senha);
			$this->pdo->exec("set names utf8");
		}
		catch (PDOException $e) {
			echo "Erro com Banco de Dados: " . $e->getMessage();
			exit();
		}
		catch (Exception $e) {
			echo "Erro genérico: " . $e->getMessage();
			exit();
		}
	}

	public function buscarDados() {
		$res = array();

		$cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
		$res = $cmd->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}

	public function cadastrarPessoa($nome, $telefone, $email) {
		// Verificar se o email já foi cadastrado
		$cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
		$cmd->bindValue(":e", $email);
		$cmd->execute();

		// Email já cadastrado
		if ($cmd->rowCount() > 0) {
			return false;
		}
		// Email não foi encontrado
		else {
			$cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
			$cmd->bindValue(":n", $nome);
			$cmd->bindValue(":t", $telefone);
			$cmd->bindValue(":e", $email);
			$cmd->execute();

			return true;
		}
	}

	public function excluirPessoa($id) {
		$cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id", $id);
		$cmd->execute();
	}

	public function buscarDadosPessoa($id) {
		$res = array();

		$cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id", $id);
		$cmd->execute();
		$res = $cmd->fetch(PDO::FETCH_ASSOC);

		return $res;
	}

	public function atualizarDados($id, $nome, $telefone, $email) {
		$cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
		$cmd->bindValue(":n", $nome);
		$cmd->bindValue(":t", $telefone);
		$cmd->bindValue(":e", $email);
		$cmd->bindValue(":id", $id);
		$cmd->execute();
	}

}
?>