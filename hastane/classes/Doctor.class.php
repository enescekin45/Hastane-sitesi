<?php 

class Doctor {
    // Yeni bir doktor ekler
    public static function add($token, $firstName, $secondName, $email, $phone, $gender, $role){
        if($token == ""){
            // Yeni bir token oluştur
            $token = md5(time().uniqid().unixtojd().$role.$email.$phone);
            $password = "hospital"; 
            
            // Kullanıcıyı ekle
            Db::insert(
                "users", 
                array("firstName", "secondName", "email", "password", "token", "status", "phone", "gender", "role"), 
                array($firstName, $secondName, $email, $password, $token, 2, $phone, $gender, $role)
            );
            
            // Başarı mesajı göster
            Messages::success("Doctor has been added successfully");
        } else {
            // Doktoru düzenle
            self::edit($token, $firstName, $secondName, $email, $phone, $role);
        }
    }
    
    // Kayıtlı doktorları yükler
    public static function load(){
        $query = Db::fetch("users", "", "status = ? ", "2", "id DESC", "", "");
        if(Db::count($query)){
            echo"<div class='form-holder'>
                    <table class='table table-bordered table-stripped'> 
                    <tr>
                        <td><strong>Ad Soyad</strong></td> 
                        <td><strong>İkinci İsim</strong></td> 
                        <td><strong>Email</strong></td> 
                        <td><strong>Telefon</strong></td> 
                        <td><strong>Cinsiyet</strong></td> 
                        <td><strong>Rol</strong></td>
                        <td><strong>Eylem</strong></td>
                    </tr>
            "; 
            
            while($data = Db::assoc($query)){
                // Veritabanından gelen verileri al
                $firstName = $data['firstName']; 
                $secondName = $data['secondName']; 
                $email = $data['email']; 
                $phone = $data['phone']; 
                $gender = $data['gender']; 
                $role = $data['role']; 
                $token = $data['token']; 
                
                // Tabloya ekle
                echo "<tr>
                        <td>$firstName</td> 
                        <td>$secondName</td> 
                        <td>$email</td> 
                        <td>$phone</td> 
                        <td>$gender</td> 
                        <td>$role</td> 
                        <td><center><a href='actions.php?action=remove-doc&token=$token'>Silme</a> | <a href='add-doctors.php?token=$token'>Düzenle</a></center></td>
                    </tr>";
            }
            
            echo "</table></div>";
            return; 
        }
        
        // Bilgi mesajı göster
        Messages::info("Kayıtlarda doktor bulunamamıştır");
    }
    
    // Doktorları bir dizi olarak döndürür
    public static function getArray($name, $labelDistance){
        $nextLabel = 12 - (int) $labelDistance; 
        $query = Db::fetch("users", "", "status = ? ", "2", "id DESC", "", "");
        $array = array(); 
        echo "<div class='form-group'>
                <label class='col-md-".$labelDistance."' >Doctors</label>
                <div class='col-md-".$nextLabel."'>
                <select name='$name' class='form-control'>
                    <option value='' >--Select a Doctor--</option>
                ";
                
        while($data = Db::assoc($query)){
            $token = $data['token']; 
            $firstName = User::get($token,"firstName"); 
            $secondName = User::get($token, "secondName"); 
            
            echo "<option value='$token'>$firstName $secondName</option> ";
        }
        echo "</select></div></div> ";
    }
    
    // Doktoru siler
    public static function remove($token){
        Db::delete("users", "token = ? ", $token);
    }
    
    // Doktor bilgilerini düzenler
    public static function edit($token, $firstName, $secondName, $email, $phone, $role){
        Db::update("users",
        array("firstName", "secondName", "email", "phone", "role"), 
        array($firstName, $secondName, $email, $phone, $role), 
        "status = ? AND token = ? ", array(2, $token)); 
        
        Messages::success("Bu doktoru düzenlediniz. <strong><a href='doctors-record.php'>View Düzenles</a></strong> ");
    }
}
