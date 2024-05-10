<?php 
// Gerekli dosyaları dahil et
require_once "importance.php"; 

// Kullanıcı oturumda değilse, giriş sayfasına yönlendir
if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<title>Randevular <?php echo CONFIG::SİSTEM_ADI; ?></title>
	<?php require_once "inc/head.inc.php";  // Başlık etiketinin içeriği ?>
</head>
<body>
	<?php require_once "inc/header.inc.php"; // Başlık bölümünün içeriği ?> 
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; // Kenar çubuğunun içeriği ?></div>
			<div class='col-md-7'>
				<div class='content-area'> 
					<div class='content-header'> 
						<!-- Sayfa başlığı ve alt başlık -->
						<h2>Gösterge Tablosu <small>Kontrol panelinizi görüntüleyin</small></h2>
					</div>
					<?php require_once "inc/alerts.inc.php"; // Uyarılar bölümünün içeriği ?> 
					<div class='content-body'> 
						<?php 
							// Doktorun randevularını yükle
							Appointment::loadDoctorAppointMents(); 
						?>
						
						<hr /> <!-- Yatay çizgi -->
						
						<h3>Müracaat Edilen Randevular</h3>
						<?php 
							// Doktorun yanıtlanmış randevularını yükle
							Appointment::loadDoctorRepliedAppointMents(); 
						?>
					</div> 
				</div> 
			</div>

			<div class='col-md-3'>
				<img src='images/doc-background-one.png' class='img-responsive' /> <!-- Resim -->
			</div> 
		</div> 
	</div> 
</body>
</html>
