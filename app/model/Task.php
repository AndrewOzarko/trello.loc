<?php 
	class Task extends ozarko\library\Model {

		public function create($desc, $dashid) {
			var_dump($dashid);
			$stmt = $this->db::prepare("INSERT INTO Task (descr, dashboard_id) VALUES (?, ?)");
			$stmt->bindParam(1, $desc);
			$stmt->bindParam(2, $dashid);
			return $stmt->execute();
		}

		public function getAll() {
			return $this->db::run("SELECT * FROM Task");
		}
	}
