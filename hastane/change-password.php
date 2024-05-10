<?php 
// Gerekli dosyaları dahil et
require_once "importance.php"; 

// Kullanıcı girişi yapılmamışsa, kullanıcıyı giriş sayfasına yönlendir
if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<!-- Sayfa başlığı -->
	<title>Şifre Değiştir <?php echo CONFIG::SİSTEM_ADI; ?></title>
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
						<h2>Şifre Değiştir <small>Güvenliğiniz için şifrenizi değiştirin</small></h2>
					</div>
					<?php require_once "inc/alerts.inc.php";  // Uyarılar bölümünün içeriği ?> 
					<div class='content-body'> 
						<div class='form-holder'> 
							<?php 
								// Eğer form gönderildiyse
								if(isset($_POST['o-p'])){
									$oldPassword = $_POST['o-p'];
									$newPassword = $_POST['n-p']; 
									$confirmPassword = $_POST['c-p']; 
									
									// Yeni şifre 5 karakterden kısa ise hata göster
									if(strlen($newPassword) < 5){
										Messages::error("Yeni şifre 5 karakterden oluşmalıdır");
									} else if($oldPassword == "" || $newPassword == ""){
										// Eski veya yeni şifre alanı boşsa hata göster
										Messages::error("Tüm alanlar doldurulmalıdır");
									} else if($newPassword != $confirmPassword){
										// Yeni şifre ve onay şifresi eşleşmiyorsa hata göster
										Messages::error("Oops! Şifreniz eşleşmedi");
									} else {
										// Şifre değiştirme işlemini gerçekleştir
										User::changePassword($oldPassword, $newPassword);
									}
								}
								
								// Form nesnesini oluştur ve başlat
								$form = new Form(2, "post"); 
								$form->init();
								// Eski şifre text kutusu
								$form->textBox("Eski Şifre", "o-p", "password", "", "");
								// Yeni şifre text kutusu
								$form->textBox("Yeni Şifre", "n-p", "password", "", ""); 
								// Yeni şifre onay text kutusu
								$form->textBox("Yeni Şifre (Tekrar)", "c-p", "password", "", "");
								// Formu kapat ve butonla birlikte gönder
								$form->close("Şifre Değiştir"); 
							?> 
						</div> 
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
