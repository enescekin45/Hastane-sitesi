<?php 
// importance.php dosyasını dahil et
require_once "importance.php"; 

// Kullanıcı girişi yapılmamışsa login.php'ye yönlendir
if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SİSTEM_ADI; ?> | Ev </title> <!-- Sayfa başlığı -->
	<?php require_once "inc/head.inc.php";  ?> <!-- head içeriğini dahil et -->
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> <!-- header içeriğini dahil et -->
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- sidebar içeriğini dahil et -->
			<div class='col-md-7'>
				<div class='content-area'> 
				<div class='content-header'> 
				Gösterge Tablosu <small>Kontrol panelinizi görüntüleyin</small> <!-- İçerik başlığı -->
				</div>
				<div class='content-body'>
					<div class='row'>
						<!-- Dashboard sınıfından draw metodu çağrılarak farklı öğelerin görüntülenmesi sağlanıyor -->
						<?php Dashboard::draw("Salgın", Dashboard::Outbreak(),  "Outbreak.php") ?> <!-- Salgın bilgilerini görüntülemek için -->
						<?php if($userStatus == 1){ Dashboard::draw("Doktorlar", Dashboard::doctors(),  "doctors-record.php"); } ?> <!-- Admin olarak giriş yapmışsa Doktorlar bilgilerini görüntülemek için -->
						<?php Dashboard::draw("Hastalar", Dashboard::patients(),  "patients.php") ?> <!-- Hastaların bilgilerini görüntülemek için -->
						<?php Dashboard::draw("Hasta Kitabı", Dashboard::getPatientRecords(),  "patients.php") ?> <!-- Hasta kayıtlarını görüntülemek için -->
						<?php Dashboard::draw("Randevular", Dashboard::Appointments(),  "appointments.php") ?> <!-- Randevuları görüntülemek için -->
						<?php Dashboard::draw("Müracaat Edilenler.", Dashboard::repliedAppointMents(),  "appointments.php") ?> <!-- Müracaat edilen randevuları görüntülemek için -->
						<?php Dashboard::draw("HIV Kayıt", Dashboard::hivPatients(),  "hiv.php") ?> <!-- HIV kayıtlarını görüntülemek için -->
						<?php Dashboard::draw("Şifre Değiştir", "",  "change-password.php"); ?> <!-- Şifre değiştirme ekranını görüntülemek için -->
					</div>
				</div>
				</div> 
				
			</div> 

			<div class='col-md-3'>
				<img src='images/doc-background-one.png' class='img-responsive' /> <!-- Resim içeriğini görüntülemek için -->
			</div>
				
		</div> 
	</div> 
</body>
</html>
