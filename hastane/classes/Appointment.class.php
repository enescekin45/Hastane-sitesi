<?php 

class Appointment{
	
	// Randevu gönderme işlemini gerçekleştirir.
	public static function send($name, $number, $phone, $message, $doctor){
		// Eğer hasta oturumda ise randevu gönderilir
		if(Patient::isPatientIn()){
			$time = time(); 
			Db::insert("appointment", 
				array("name", "fromm", "phone", "message", "too", "cTime"), 
				array($name, $number, $phone, $message, $doctor, $time)
			);
			Messages::success("Randevunuz gönderildi");
			return; 
		} 
		Messages::error("Giriş yapmış olmalısınız");
	}
	
	// Hasta tarafından gönderilen randevuları yükler.
	public static function loadPatientSentAppointments(){
		// Hasta oturumunda ise gönderilen randevular yüklenir
		if(Patient::isPatientIn()){
			$query = Db::fetch("appointment", "", "fromm = ?", $_SESSION['patient'], "", "", "" );
			if(!Db::count($query)){
				Messages::info("Şu anda gönderilmiş veya rezerve edilmiş randevunuz yok");
				return; 
			}
			// Gönderilen randevular tablo şeklinde gösterilir
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Doctor", "Message"); 
			Table::header($header);
			while($data = Db::assoc($query) ){
				$docToken = $data['too']; 
				$doctorName = User::get($docToken, "firstName")." ".User::get($docToken, "secondName");
				Table::body(array($doctorName, $data['message']));
			}
			Table::close();
			echo "</div>"; 
			return; 
		} 
		Messages::error("Giriş yapmış olmalısınız");
	}
	
	
	// Hasta tarafından cevaplanan randevuları yükler.
	public static function loadPatientRepliedAppointment(){
		// Hasta oturumunda ise cevaplanan randevuları yükler
		if(Patient::isPatientIn()){
			$query = Db::fetch("appointment", "", "too = ?", $_SESSION['patient'], "", "", "" );
			if(!Db::count($query)){
				Messages::info("Şu anda alınmış veya rezerve edilmiş randevunuz yok");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Doctor", "Message"); 
			Table::header($header);
			while($data = Db::assoc($query) ){
				$docToken = $data['fromm']; 
				$doctorName = User::get($docToken, "firstName")." ".User::get($docToken, "secondName");
				Table::body(array( $doctorName, $data['message']));
			}
			Table::close();
			echo "</div>"; 
			return; 
		} 
		Messages::error("Giriş yapmış olmalısınız");
	}
	
	// Doktorun aldığı randevuları yükler.
	public static function loadDoctorAppointMents(){
		if(User::loggedIn()){
			$query = Db::fetch("appointment", "", "too = ?", User::getToken(), "", "", "" );
			if(!Db::count($query)){
				Messages::info("Şu anda alınmış veya rezerve edilmiş randevunuz yok");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Patient Number", "Name",  "Message", "Action"); 
			$body = array();
			Table::header($header); 
			while($data = Db::assoc($query) ){
				$number = $data['fromm']; 
				Table::body(array($number, $data['name'], $data['message'], "<center><a href='reply-appointment.php?patient=$number'>Reply</a></center>")); 
			}
			Table::close();
			echo "</div>"; 
			return; 
		} 
		Messages::error("Giriş yapmış olmalısınız");
	}
	
	// Doktorun cevapladığı randevuları yükler.
	public static function loadDoctorRepliedAppointMents(){
		if(User::loggedIn()){
			$query = Db::fetch("appointment", "", "fromm = ?", User::getToken(), "", "", "" );
			if(!Db::count($query)){
				Messages::info("Şu ana kadar hiçbir randevuya cevap vermediniz.");
				return; 
			}
			
			echo "<div class='form-holder'>";
			Table::start(); 
			$header = array("Patient Number", "Name",  "Message"); 
			$body = array();
			Table::header($header); 
			while($data = Db::assoc($query) ){
				$number = $data['too']; 
				Table::body(array($number, $data['name'], $data['message']));
			}
			Table::close();
			echo "</div>"; 
			return; 
		} 
		Messages::error("Giriş yapmış olmalısınız");
	}
	
	// Randevuya cevap verme işlemini gerçekleştirir.
	public static function reply($message, $number){
		if(!User::loggedIn()){
			Messages::error("Bu işlemi tamamlamak için oturum açmış olmanız gerekir");
			return; 
		}
		if($message == "" || $number == ""){
			Messages::error("Lütfen bir mesaj girin");
			return; 
		}
		
		$time = time(); 
		$name = "Doctor";
		$phone = "0725895256"; 
		
		Db::insert("appointment", 
			array("name", "fromm", "phone", "message", "too", "cTime"), 
			array($name, User::getToken(), $phone, $message, $number, time() )
		);
		Messages::success("Reply sent");
	}
}
