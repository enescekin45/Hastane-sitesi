<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

if(!User::loggedIn()){
	Config::redir("login.php"); // Kullanıcı oturum açmamışsa, giriş sayfasına yönlendir
}
?> 

<html>
<head>
	<title>Hastalar Kitabı - <?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
	<?php require_once "inc/head.inc.php";  ?> <!-- Başlık kısmını içeri aktar -->
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> <!-- Başlık bölümünü içeri aktar -->
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- Yan çubuğu içeri aktar -->
			<div class='col-md-10'>
				<div class='content-area'> 
					<div class='content-header'> 
						Hastalar <small>Hasta defteri / kaydı</small> <!-- Başlık ve alt başlık -->
					</div>
					<div class='content-body'> 
						<?php Patient::patientsBooks(); ?> <!-- Hastaların defterini veya kayıtlarını gösterme fonksiyonunu çağır -->
					</div>
				</div> 
			</div>
		</div> 
	</div> 
</body>
</html>
