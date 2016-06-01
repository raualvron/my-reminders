<?php

require_once 'DbConnection.php';


class EventReminder {

	private $conn;
    
    public function __construct()
    {
        $database   = new DbConnection();
        $db         = $database->dbConnection();
        $this->conn = $db;
    }

	public function getEvents($code, $email) {
		
		$events = array();
		$stmt = $this->conn->query("SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "'");
		while($userRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$e = array();
			$e['id'] = $userRow['ID'];
			$e['title'] = $userRow['title'];
			$e['start'] = $userRow['start'];
			$e['end'] = $userRow['end'];
			$e['description'] = $userRow['description'];
			$allday = ($userRow['allDay'] == "true") ? true : false;
   			$e['allDay'] = $allday;

			array_push($events, $e);
		}

		return json_encode($events);
	}

	public function getEventID($code, $email) {

		$stmt = $this->conn->query("SELECT * FROM myr_events WHERE eventCode = '" . $code . "' AND email = '" . $email . "'");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result[0];

	}

	public function addEvent($codeEvent, $code, $email, $title, $timezone, $description, $start, $end) {

		$stmt = $this->conn->prepare("INSERT INTO myr_events (eventCode, code, email, title, timezone, description, start, end) VALUES (:eventCode,:code, :email, :title, :timezone, :description, :start, :end)");
		$stmt->bindParam(':eventCode', $codeEvent);
		$stmt->bindParam(':code', $code);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':timezone', $timezone);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':start', $start);
		$stmt->bindParam(':end', $end);
		$stmt->execute();
	}


	public function removeEvent($eventCode, $code, $email) {

		$stmt = $this->conn->prepare("DELETE FROM myr_events WHERE eventCode = :eventCode AND code = :code AND email = :email");
		$stmt->bindParam(':eventCode', $eventCode);
		$stmt->bindParam(':code', $code);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
	}

	public function editEvent($code, $email, $title, $timezone, $description, $start, $end) {

		$stmt = $this->conn->prepare("UPDATE myr_events SET title = :title, description = :description, start = :start, end = :end WHERE eventCode = :eventCode AND email = :email");
		$stmt->bindParam(':eventCode', $code);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':start', $start);
		$stmt->bindParam(':end', $end);
		$stmt->execute();
	}

	public function getEventStatusNum($code, $email, $type) {
		
		// Obteniendo la actual fecha
		$date = date('Y-m-d H:i:s');

		if ($type == "Pending") {

			$sql = "SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "' AND start > '" . $date . "'";

		} elseif ($type == "Finish") {

			$sql = "SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "' AND start < '" . $date . "'";
		
		} elseif ($type == "Total") {

			$sql = "SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "'";

		}

		$num_row = 0;

		foreach ($this->conn->query($sql) as $row) {
			$num_row++;
		}
		
		return $num_row;
	}


	public function getEventPerStatus($code, $email, $type) {
		
		// Obteniendo la actual fecha
		$date = date('Y-m-d H:i:s');

		if ($type == "Pending") {

			$sql = "SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "' AND start > '" . $date . "' ORDER BY ID ASC LIMIT 5";

		} elseif ($type == "Finish") {

			$sql = "SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "' AND start < '" . $date . "' ORDER BY ID ASC LIMIT 5";
		
		} elseif ($type == "Total") {

			$sql = "SELECT * FROM myr_events WHERE code = '" . $code . "' AND email = '" . $email . "' ORDER BY ID ASC LIMIT 5 ";

		}

		$events = array();
		$stmt = $this->conn->query($sql);
		while($evenRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$e = array();
			$e['id'] = $evenRow['ID'];
			$e['eventCode'] = $evenRow['eventCode'];
			$e['code'] = $evenRow['code'];
			$e['title'] = $evenRow['title'];
			$e['start'] = $evenRow['start'];
			$e['end'] = $evenRow['end'];
			if ($evenRow['start'] > $date) { $e['status'] = "Pending"; } else { $e['status'] = "Finish"; }
			$e['description'] = $evenRow['description'];
			$e['timezone'] = $evenRow['timezone'];
			array_push($events, $e);
		}

		return $events;
	}
}

