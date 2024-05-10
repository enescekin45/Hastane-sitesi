<?php 

require_once "importance.php"; // Gerekli dosyaları içeri aktar

@session_destroy(); // Oturumu sonlandır (eğer başlatılmışsa)

setcookie("emr-user", $token ,time()-(60*60*24*7*30),"/", "","",TRUE); // Kullanıcı çerezini sil

Config::redir("login.php"); // Kullanıcıyı giriş sayfasına yönlendir

?>
