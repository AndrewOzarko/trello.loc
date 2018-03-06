<?php 
	class User extends ozarko\library\Model {

		public function getByEmail($email) {
			$sql = $this->db::run("SELECT * FROM User WHERE email=? LIMIT 1;", [$email])->fetch();
			return $sql;
		}

		public function emailExists($email) {
			$sql = $this->db::run("SELECT email FROM User WHERE email=? LIMIT 1;", [$email])->fetch();
			return ($email == $sql['email']) ? true : false;
		}

		public function create($name, $password, $email, $sess) {
			$stmt = $this->db::prepare("INSERT INTO User (name, password, email, sess) VALUES (?, ?, ?, ?)");
			$stmt->bindParam(1, $name);
			$stmt->bindParam(2, $password);
			$stmt->bindParam(3, $email);
			$stmt->bindParam(4, $sess);
			return $stmt->execute();

		}

		public function updateSess($sess, $email) {
			return DB::run("UPDATE User SET sess=? WHERE email=?", [$sess, $email]);
		}
	}
?>