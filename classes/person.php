<?php
	class Person {
		private $classPDO;

		// Conexão com o Banco de Dados
		public function __construct($host, $dbname, $user, $password) {
			try {
				$this->classPDO = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $password);
				$this->classPDO->exec("set names utf8");
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

		public function fetchData() {
			$result = array();
			$command = $this->classPDO->query("SELECT * FROM person ORDER BY name");
			$result = $command->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}

		public function registerPerson($name, $phone, $email) {
			// Verificar se o email já foi cadastrado
			$command = $this->classPDO->prepare("SELECT id FROM person WHERE email = :e");
			$command->bindValue(":e", $email);
			$command->execute();

			if ($command->rowCount() > 0) { // Email já cadastrado
				return false;
			}
			else { 							// Email não foi encontrado
				$command = $this->classPDO->prepare("INSERT INTO person (name, phone, email) VALUES (:n, :p, :e)");
				$command->bindValue(":n", $name);
				$command->bindValue(":p", $phone);
				$command->bindValue(":e", $email);
				$command->execute();

				return true;
			}
		}

		public function deletePerson($id) {
			$command = $this->classPDO->prepare("DELETE FROM person WHERE id = :id");
			$command->bindValue(":id", $id);
			$command->execute();
		}

		public function fetchPersonData($id) {
			$result = array();
			$command = $this->classPDO->prepare("SELECT * FROM person WHERE id = :id");
			$command->bindValue(":id", $id);
			$command->execute();
			$result = $command->fetch(PDO::FETCH_ASSOC);

			return $result;
		}

		public function updateData($id, $name, $phone, $email) {
			$command = $this->classPDO->prepare("UPDATE person SET name = :n, phone = :p, email = :e WHERE id = :id");
			$command->bindValue(":n", $name);
			$command->bindValue(":p", $phone);
			$command->bindValue(":e", $email);
			$command->bindValue(":id", $id);
			$command->execute();
		}
	}
?>