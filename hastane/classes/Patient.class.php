<?php 

class Patient{
    // Yeni bir hasta ekler
    public static function add($name, $location, $age, $gender, $phone, $dateOfBirth, $diagnosis, $prescriptions, $doctor, $number, $condition){
        // Gerekli alanların boş olup olmadığını kontrol eder
        if($name == "" || $location == "" || $age == "" || $gender == "" || $phone == "" || $dateOfBirth == "" || $diagnosis == "" || $prescriptions == "" || $condition == ""){
            Messages::error("Tüm alanlar zorunludur"); 
            return; 
        }
        
        // Telefon numarasının uzunluğunu kontrol eder
        if(strlen($phone) != 10){
            Messages::error("Lütfen telefon numarasını 10 haneli olarak girin (0712345678)");
            return;
        }
        
        // Doğum tarihine göre doğru yaşın hesaplanması
        $today = strftime(date("d-m-Y", time()));
        $todayData = explode("-", $today);
        $dataYear = explode("-", $dateOfBirth); 
        $correctAge = (int) $todayData[2] -  $dataYear[0];
        $correctDateOfBirth = $dataYear[2]." - ".$dataYear[1]." - ".$dataYear[0];
        
        // Girilen yaşın hesaplanan yaşla uyuşup uyuşmadığının kontrolü
        if($age != $correctAge){
            Messages::error("Hastanın doğum tarihi $correctDateOfBirth olarak belirtilmiş, bu nedenle yaşları $age. Doğru yaş $correctAge olmalıdır. Lütfen ayrıntıları düzeltin ");
            return; 
        }
        
        $time = time(); 
        $patientToken = md5(uniqid().time().unixtojd().$name.$age.$phone); 
        $diagnosis = str_replace("\n", "<br />", $diagnosis); 
        $prescriptions = str_replace("\n", "<br />", $prescriptions);
        
        // Hasta veritabanına eklenir
        Db::insert("patients", 
                array("name", "location", "age", "gender", "phone", "dateOfBirth", "cTime", "diagnosis", "prescription", "token", "doctor", "number", "pcondition"), 
                array($name, $location, $correctAge, $gender, $phone, $correctDateOfBirth, $time, $diagnosis, $prescriptions, $patientToken, $doctor, $number, $condition )
        ); 
        
        // Yazdırma sayfasına yönlendirme
        Config::redir("print.php?patient=$patientToken"); 
    }
    
    // Belirtilen belirteç ve alan için hasta bilgisini getirir
    public static function get($token, $field){
        $query = Db::fetch("patients", "$field", "token = ? ", $token, "", "", ""); 
        if(Db::count($query)){
            $data = Db::num($query); 
            return $data[0];
        }
        
        Messages::error("Geçersiz hasta belirteci!"); 
    }
    
    // Belirtilen numara ve alan için hasta bilgisini getirir
    public static function getP($number, $field){
        $query = Db::fetch("patients", "$field", "number = ? ", $number, "", "", 1); 
        if(Db::count($query)){
            $data = Db::num($query); 
            return $data[0];
        }
        
        Messages::error("Geçersiz hasta belirteci!"); 
    }
    
    // Belirtilen belirteçle hasta bilgisini yazdırır
    public static function printP($token){
        // Hasta bilgilerini çeker
        $name = self::get($token, "name");
        $location = self::get($token, "location"); 
        $age = self::get($token, "age"); 
        $phone = self::get($token, "phone"); 
        $dateOfBirth = self::get($token, "dateOfBirth"); 
        $time = self::get($token, "cTime"); 
        $diagnosis = self::get($token, "diagnosis"); 
        $prescription = self::get($token, "prescription");
        $date = strftime(date("d/m/Y", $time));
        $doctor = self::get($token, "doctor");
        $number = self::get($token, "number");
        
        // Hasta bilgilerini yazdırma sayfasında gösterir
        echo "
            <div class='badge-header print-p-data' style='cursor: pointer;'>Yazdır</div>
            <div class='print-data'>
                <div class='form-holder' style='background:#fff;'>
                    
                    <div class='row'>
                        <div class='col-md-7 p-data'><div class='p-date'>$date</div></div>
                        <div class='col-md-5 p-data'>
                            <div><strong>Hasta No:</strong> <span>$number</span></div>
                            <div><strong>İsim:</strong> <span>$name</span></div>
                            <div><strong>Yaş:</strong> <span>$age</span></div>
                            <div><strong>İletişim:</strong> <span>$phone</span></div>
                            <div><strong>Konum:</strong> <span>$location</span></div>
                        </div>
                    </div><br /> 
                    
                    <div class='row'>
                        <div class='col-md-7 p-ref'>
                            <div>DETAYLAR</div>
                            $diagnosis
                        </div>
                        
                    </div>
                    
                    
                    <div class='row'>
                        <div class='col-md-7 p-ref'>
                            <div>REÇETELER</div>
                            $prescription
                        </div>
                        
                    </div><br />
                    
                    
                    <div class='row'>
                        <div class='col-md-7'>Murang'a Sevk Hastanesi</div>
                        <div class='col-md-5'>
                            <strong>Hizmet Veren: </strong> <span class='service-name'> ".User::get($doctor, "firstName")." ".User::get($doctor, "secondName")."</span> <span class='service-title'><i>".User::get($doctor, "role")."</i></span>
                        </div>
                        
                    </div>
                    
                    
                </div> 
            </div> 
        ";
    }
    
    // Tüm hastaların kayıtlarını listeler
    public static function patientsBooks(){
        $query = Db::fetch("patients", "", "", "", "id DESC", "", ""); 
        
        if(Db::count($query)){
            if(Db::count($query) == 1){
                $countP = Db::count($query)." Record";
            } else {
                $countP = Db::count($query)." Records";
            }
            echo "<div class='badge-header'>$countP</div>"; 
            
            echo "<div class='form-holder'><table class='table table-bordered'>";
            
            echo "
                    <tr>
                        <td><strong>İsim</strong></td>
                        <td><strong>Konum</strong></td>
                        <td><strong>Yaş</strong></td>
                        <td><strong>Katıldım</strong></td>
                        <td><strong>Doktor</strong></td>
                        <td><strong>Yazdır</strong></td>
                        
                    <tr>
            "; 
            while($data = Db::assoc($query)){
                $token = $data['token'];
                $name = self::get($token, "name");
                $location = self::get($token, "location"); 
                $age = self::get($token, "age"); 
                $phone = self::get($token, "phone"); 
                $dateOfBirth = self::get($token, "dateOfBirth"); 
                $time = self::get($token, "cTime"); 
                $diagnosis = self::get($token, "diagnosis"); 
                $prescription = self::get($token, "prescription");
                $date = strftime(date("d/m/Y", $time));
                $doctor = self::get($token, "doctor");
                $docName = User::get($doctor, "firstName")." ".User::get($doctor, "secondName");
                
                echo "
                    <tr>
                        <td>$name</td>
                        <td>$location</td>
                        <td>$age</td>
                        <td>$date</td>
                        <td>$docName</td>
                        <td><a href='print.php?patient=$token'>yazdır</a></td>
                        
                    <tr>
            "; 
            }
            
            echo "</table></div>";
        } else {
            Messages::info("Şu anda hiçbir kayıt yok"); 
        }
    }
    
    // Belirtilen numara ile kayıtlı bir hasta var mı diye kontrol eder
    public static function checkPatient($number){
        $query = Db::fetch("patients", "", "number =? ", $number, "", "", 1); 
        if(!Db::count($query)){
            Messages::error("Bu numara sistemde mevcut değil"); 
            return;
        }
        
        if($number == "" || strpos($number, " ") === true ){
            Messages::error("Bir numara vermelisiniz"); 
            return;
        }
        
        $data = Db::assoc($query);
        
        $name = $data['name']; 
        $location = $data['location'];
        $age = $data['age']; 
        $phone = $data['phone'];
        $dateOfBirth = $data['dateOfBirth'];
        $gender = $data['gender']; 
        
        Config::redir("add-patient.php?p-number=$number&name=$name&location=$location&age=$age&phone=$phone&dateOfBirth=$dateOfBirth&gender=$gender");
        
    }
    
    // Belirtilen telefon ve numara ile hasta yetkilendirme
    public static function authorize($phone, $number){
        $query = Db::fetch("patients", "", "phone = ? AND number = ? ", array($phone, $number), "", "", 1); 
        if(!Db::count($query)){
            Messages::error("Girdiğiniz bilgiler kayıtlarımızdan hiçbiriyle eşleşmedi");
            return; 
        }
        
        if($phone == "" || $number == "" || strpos($phone, " ") === true || strpos($number, " ")  == true ){
            Messages::error("Girdiğiniz bilgiler kayıtlarımızdan hiçbiriyle eşleşmedi");
            return; 
        }
        
        @session_start();
        
        $_SESSION['patient'] = $number;
        
        Config::redir("patient-data.php");
        
    }
    
    // Belirtilen hasta için tüm verileri getirir
    public static function getPatientData($patient){
        $query = Db::fetch("patients", "", "number = ? ", "$patient", "", "", ""); 
        if(!Db::count($query)){
            Messages::info("Şu anda sistemde veriniz yok");
            return; 
        }
        
        Table::start();
        
        $heading = array("İsim", "Konum", "Yaş", "Telefon", "Doğum Tarihi", "Served On:", "Teşhis", "Reçeteler", "Served By", "Yazdır");
        $body = array();
        Table::header($heading); 
        
        while($data = Db::assoc($query)){
            $token = $data['token']; 
            $name = self::get($token, "name");
            $location = self::get($token, "location"); 
            $age = self::get($token, "age"); 
            $phone = self::get($token, "phone"); 
            $dateOfBirth = self::get($token, "dateOfBirth"); 
            $time = self::get($token, "cTime"); 
            $diagnosis = self::get($token, "diagnosis"); 
            $prescription = self::get($token, "prescription");
            $date = strftime(date("d/m/Y", $time));
            $doctor = self::get($token, "doctor");
            
            $doctorFirstName = User::get($doctor, "firstName"); 
            $doctorSecondName = User::get($doctor, "secondName");
            $servedBy = "Served by $doctorFirstName $doctorSecondName";
            Table::body(array($name, $location, $age, $phone, $dateOfBirth, $date, $diagnosis, $prescription, $servedBy, "<a href='print.php?patient=$token'>Yazdır & İndir</a>"));
            
        }
        
        Table::close();
    }
    
    // Oturumda bir hasta var mı diye kontrol eder
    public static  function isPatientIn(){
        if(isset($_SESSION['patient'])){
            return true; 
        }
        return; 
    }
    
} 
?>
