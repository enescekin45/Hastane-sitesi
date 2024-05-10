<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

if(!Patient::isPatientIn()){
	Config::redir("login.php"); // Eğer hastanın oturumu açılmamışsa, giriş sayfasına yönlendir
}
?> 

<html>
<head>
	<title>Ayarlanmış Randevular <?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
	<?php require_once "inc/head.inc.php";  ?> <!-- Başlık kısmını içeri aktar -->
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> <!-- Başlık bölümünü içeri aktar -->
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- Yan çubuğu içeri aktar -->
			<div class='col-md-7'>
				<div class='content-area'> 
					<div class='content-header'> 
						Gönderilen Randevular <small>Gönderilen randevularınızı görüntüleyin</small> <!-- Başlık ve alt başlık -->
					</div>
					<div class='content-body'> 
						<?php Appointment::loadPatientSentAppointments();  ?> <!-- Hastanın ayarlanmış randevularını yükleme fonksiyonunu çağır -->
					</div>
				</div> 
			</div>
			<div class='col-md-3'>
				<img src='images/doc-background-one.png' class='img-responsive' /> <!-- Sağ taraftaki görsel -->
			</div> 
		</div> 
	</div> 
</body>
</html>
