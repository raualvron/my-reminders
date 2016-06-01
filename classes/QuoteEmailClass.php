<?php 

class QuoteEmailClass {

	private $conn;

	public function __construct()
	{
		
		$database   = new DbConnection();
		$db         = $database->dbConnection();
		$this->conn = $db;

		$mail = new PHPMailer;
		$this->mail = $mail;

	}
	

	public function insertEmail($codeEvent, $email_to, $title, $description, $status, $timezone,  $start) {  

		$code = md5(uniqid(rand()));
		$emailFrom = 'info@myreminders.com';
		if(!isset($status) && empty($status)) { $status = "Automatic"; }

		$date = explode(" ", $start);

		$stmt = $this->conn->prepare("INSERT INTO myr_emails(codeEmail , code, email_from , email_to , subject, message, status, timezone, date_send, time_send) 
			VALUES(:codeEmail, :code, :email_from, :email_to, :subject, :message, :status, :timezone, :date_send, :time_send)");
		$stmt->bindparam(":codeEmail", $codeEvent);
		$stmt->bindparam(":code", $code);
		$stmt->bindparam(":email_from", $emailFrom);
		$stmt->bindparam(":email_to", $email_to);
		$stmt->bindparam(":subject", $title);
		$stmt->bindparam(":message", $description);
		$stmt->bindparam(":status", $status);
		$stmt->bindparam(":timezone", $timezone);
		$stmt->bindparam(":date_send", $date[0]);
		$stmt->bindparam(":time_send", $date[1]);
		$stmt->execute();
	}

	public function editEmail($codeEvent, $title, $description, $start) { 

		$date = explode(" ", $start);

		$stmt = $this->conn->prepare("UPDATE myr_emails SET subject = :subject, message = :message, date_send = :date_send, time_send = :time_send WHERE codeEmail = :codeEmail");
		$stmt->bindparam(":codeEmail", $codeEvent);
		$stmt->bindparam(":subject", $title);
		$stmt->bindparam(":message", $description);
		$stmt->bindparam(":date_send", $date[0]);
		$stmt->bindparam(":time_send", $date[1]);
		$stmt->execute();

	}

	public function getEmailPending() {
		
		$email = array();

		$stmt = $this->conn->query("SELECT * FROM myr_emails WHERE (status = 'Pending' AND date_send = CURDATE() AND DATE_FORMAT(time_send, '%H')  = HOUR(CURTIME()) AND DATE_FORMAT(time_send, '%i')  = MINUTE(CURTIME())) OR (status = 'Automatic')");
		while($emailRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$e = array();
			$e['id'] = $emailRow['ID'];
			$e['email_to'] = $emailRow['email_to'];
			$e['subject'] = $emailRow['subject'];
			$e['message'] = $emailRow['message'];
			array_push($email, $e);
		}

		return $email;
	}


	public function changeStatusEmail() {

		$result = self::getEmailPending();
		$ids = array();

		for ($i=0; $i < count($result); $i++) { 
			$stmt = $this->conn->query("UPDATE myr_emails SET status = 'Sent' WHERE ID = '" . $result[$i]['id'] . "'");
			array_push($ids, $result[$i]['id']);
		}

		return $ids;
	}

	public function sendEmail() {

		$result = self::changeStatusEmail();

		foreach ($result as $key) {

			$stmt = $this->conn->query("SELECT * FROM myr_emails WHERE ID = '" .  $key . "'");
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$id = $row['ID'];
			$subject = $row['subject'];
			$email_to = $row['email_to'];
			$description = $row['message'];

			$message = file_get_contents('assets/templates/email.html'); 
    		$message = str_replace('%%username%%', $email_to, $message); 
    		$message = str_replace('%%title%%', $subject, $message); 
    		$message = str_replace('%%subject%%', $description, $message); 

			$this->mail->isSMTP();                                    
			$this->mail->Host = 'mailtrap.io';
			$this->mail->SMTPAuth = true;
			$this->mail->Username = '';          
			$this->mail->Password = '';                   
			$this->mail->SMTPSecure = 'tls';                   
			$this->mail->Port = 2525;

			$this->mail->setFrom('' , 'info@reminders.com');
			$this->mail->addAddress($email_to);

			$this->mail->CharSet="utf-8";
			$this->mail->isHTML(true);

			$this->mail->Subject = "#". $key . " - " . $subject;
			$this->mail->MsgHTML($message);

			if(!$this->mail->send()) 
			{
				echo "Mailer Error: " . $this->mail->ErrorInfo;
			} 
			else 
			{
				echo "Message has been sent successfully";
			}
		}
	}
}