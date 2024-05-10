<?php 

// Tampon belleği etkinleştir
ob_start();
// Oturumu başlat
@session_start();

// Sınıfları otomatik olarak yükleyen bir işlev tanımlayın
function autoloadClasses($className){
    require_once "classes/$className.class.php"; 
}

// spl_autoload_register fonksiyonu, belirtilen fonksiyonu otomatik yükleyici olarak kaydeder
spl_autoload_register('autoloadClasses');

// Kullanıcı girişi yapılmışsa
if(User::loggedIn()){
    // Kullanıcı bilgilerini al
	$token = $_COOKIE['emr-user']; 
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
	
    // Kullanıcı durumunu kontrol ederek rolü belirle
	if($userStatus == 1){
		$userRole = "Admin";
	} else {
		$userRole = $userRole;
	}
}
