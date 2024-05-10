<?php

// Kullanıcı işlemleri için bir sınıf
class User {
    
    // Kullanıcının giriş yapmış olup olmadığını kontrol eder
    public static function loggedIn() {
        if (isset($_COOKIE['emr-user']) && $_COOKIE['emr-user'] != "") {
            return true;
        }
        return false;
    }

    // Kullanıcıyı giriş yaptırır ve giriş durumunu kontrol eder
    public static function login($email, $password, $status) {
        // Kullanıcı bilgilerini veritabanında kontrol eder
        $query = Db::fetch("users", "token", "email = ? AND password = ? AND status = ?  ", array($email, $password, $status), "", "", "" ); 
        if (Db::count($query)) {
            Messages::success("Giriş Başarılı");
            $tokenArray = Db::num($query); 
            $token = $tokenArray[0]; 

            // Çerez oluşturur ve tarayıcıya kaydeder
            setcookie("emr-user", $token ,time()+(60*60*24*7*30),"/", "","",TRUE);

            // Ana sayfaya yönlendirme yapar
            Config::redir("index.php"); 

            return; 
        }
        
        // Hata mesajları oluşturur
        if ($status == 1) {
            $user = "a Doctor";
        } else {
            $user = "an Admin"; 
        }

        Messages::error("E-posta adresiniz ya da şifreniz yanlış. <strong>BEKLEYİN</strong>, $user olarak mı giriş yapmak istediniz? Oturum açmak için lütfen <strong><a href='login.php'>BURAYA</a></strong> tıklayın $user "); 
    }

    // Belirtilen kullanıcı belirtilen alanın değerini döndürür
    public static function get($token, $field) {
        $query = Db::fetch("users", "$field", "token = ? ", $token, "", "", "" );
        $data = Db::num($query); 
        return $data[0]; 
    }
    
    // Oturum açık ise kullanıcıya ait token'ı döndürür
    public static function getToken() {
        if (self::loggedIn()) {
            return $_COOKIE['emr-user']; 
        }
        return ""; 
    }
    
    // Kullanıcı profili bilgilerini görüntüler
    public static function profile($token) {
        // Kullanıcı profili bilgilerini çeker
        $userFirstName = User::get($token, "firstName");
        $userSecondName = User::get($token, "secondName");
        $userEmail = User::get($token, "email");
        $userPassword = User::get($token, "password");
        $userToken = User::get($token, "token");
        $userStatus = User::get($token, "status");
        $userPhone = User::get($token, "phone");
        $userProfile = User::get($token, "profile");
        $userGender = User::get($token, "gender");
        $userRole = User::get($token, "role");
        
        // Kullanıcının rolünü belirler
        if ($userStatus == 1) {
            $userRole = "Admin";
        } else {
            $userRole = $userRole;
        } 
        
        echo "<div class='form-holder'>";
        
        // Profil bilgilerini formda görüntüler
        $form = new Form(3, "post");
        $form->init();
        $form->textBox("İlk İsim", "user-fn", "text",  $userFirstName, array("readonly='readonly'", "  style='font-size: 17px;' ") );
        $form->textBox("İkinci İsim", "user-sn", "text",  $userSecondName, array("readonly='readonly'", "  style='font-size: 17px;' ") );
        $form->textBox("Email", "user-em", "text",  $userEmail, array("readonly='readonly'", "  style='font-size: 17px;' ") );
        $form->textBox("Rol", "user-rol", "text",  $userRole, array("readonly='readonly'", "  style='font-size: 17px;' ") );
        $form->textBox("Cinsiyet", "user-cinsiyet", "text",  $userGender, array("readonly='readonly'", "  style='font-size: 17px;' ") );
        $form->textBox("Telefon", "user-telefon", "text",  $userPhone, array("readonly='readonly'", "  style='font-size: 17px;' ") );
        $form->close("");
        
        echo "</div>";
    }
    
    // Kullanıcının şifresini değiştirir
    public static function changePassword($oldPassword, $newPassword) {
        // Oturum açık mı kontrol eder
        if (!self::loggedIn()) {
            Messages::error("Önce giriş yapın!"); 
            return; 
        }
        
        // Mevcut şifreyi kontrol eder
        $query = Db::fetch("users", "password", "token = ? ", self::getToken(), "", "", "");
        $dataCurrentPassword = Db::num($query); 
        $currentPassword = $dataCurrentPassword[0]; 
        if ($currentPassword != $oldPassword) {
            Messages::error("Eski şifreniz sistemde bulunamadı"); 
            return; 
        }
        
        // Yeni şifreyi günceller
        Db::update("users", array("password"), array($newPassword), "token = ? ", self::getToken()); 
        Messages::success("Şifreniz güncellendi"); 
    }
}
?>
