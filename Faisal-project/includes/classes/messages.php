<?php
	class Message
	{
		protected $db;
		private $error_message;
		public function __construct($db)
		{
			$this->db = $db;
		}
		public function send_message($subject,$messages,$to,$from)
		{
			$d = time();
			$subject = addslashes($subject);
			$messages= addslashes($messages);
			$subject= htmlentities($subject);
			$messages = htmlentities($messages);
			$query = "insert into message_inbox values('','$from','$to','$subject','$messages','$d','false','false')";
			$result = $this->db->query($query);
			if($result > 0)
			{
				$quer = "insert into message_sent values('','$from','$to','$subject','$messages','$d','false','false')";
				return $resut	= $this->db->query($quer);
			}
			

		}
		public function delete_sent_messages($x,$command,$id)
		{
				if($command=="delete"){
				$n = split(',',$x);
				if (count($n) == 1)
					$query = "delete from message_sent where sentfrom =".$id." and id = ".$x;
				else
					$query = "delete from message_sent where sentfrom =".$id." and id in(".$x.")";
					
				return $this->db->query($query);
			}				
		}
		public function delete_mail_messages($x,$command,$id)
		{
			if($command=="delete"){
				$n = split(',',$x);
				if (count($n) == 1)
					$query = "delete from message_inbox where sentto =".$id." and id = ".$x;
				else
					$query = "delete from message_inbox where sentto =".$id." and id in(".$x.")";
					
				return $this->db->query($query);
			}
			else{
				$n = split(',',$x);
				if (count($n) == 1){
					$query = "update message_inbox set deleted=true , isread='false' where sentto =".$id." and id = ".$x; }
				else
					$query = "update message_inbox set deleted=true , isread='false' where sentto =".$id." and id in(".$x.")";
					
				return $this->db->query($query);
			}
		}
		public function move_to_inbox($x,$id){
			$n = split(',',$x);
				if (count($n) == 1){
					$query = "update message_inbox set deleted='false', isread='false' where sentto =".$id." and id = ".$x; }
				else
					$query = "update message_inbox set deleted='false', isread='false' where sentto =".$id." and id in(".$x.")";
					
				return $this->db->query($query);
		}
	}$message= new Message($db);
?>
