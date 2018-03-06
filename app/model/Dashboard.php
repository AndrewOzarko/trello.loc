<?php 
	class Dashboard extends ozarko\library\Model {

		public function create($name) {
			$stmt = $this->db::prepare("INSERT INTO Dashboard (name) VALUES (?)");
			$stmt->bindParam(1, $name);
			return $stmt->execute();
		}

		public function getName() {
			return $this->db::run("SELECT name FROM Dashboard");
		}
	}
