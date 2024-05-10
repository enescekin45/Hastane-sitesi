<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

if(!User::loggedIn()){
	Config::redir("login.php"); // Kullanıcı oturum açmamışsa, giriş sayfasına yönlendir
}
?> 

<html>
<head>
	<title>Şifre Değiştir<?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
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
						Şifre Değiştir <small>Kontrol panelinizi görüntüleyin</small> <!-- Başlık ve alt başlık -->
					</div>
					<?php require_once "inc/alerts.inc.php";  ?> <!-- Uyarılar kısmını içeri aktar -->
					<div class='content-body'> 
						<div class='form-holder'> 
							<?php 
							
							if(isset($_POST['o-p'])){
								$oldPassword = $_POST['o-p'];
								$newPassword = $_POST['n-p']; 
								$confirmPassword = $_POST['c-p']; 
								
								if(strlen($newPassword) < 5){
									Messages::error("Yeni şifre 5 karakterden oluşmalıdır");
								} else if($oldPassword == "" || $newPassword == ""){
									Messages::error("Tüm alanlar alan olmalıdır");
								} else if($newPassword != $confirmPassword){
									Messages::error("Oops! Şifreniz eşleşmedi");
								} else {
									User::changePassword($oldPassword, $newPassword); // Şifre değiştirme fonksiyonunu çağır
								}
								
							}
							
							$form = new Form(2, "post"); // Form nesnesini oluştur
							$form->init();
							$form->textBox("Eski Şifre", "o-p", "Şifre", "", ""); // Eski şifre alanı
							$form->textBox("Yeni Şifre", "n-p", "Şifre", "", ""); // Yeni şifre alanı
							$form->textBox("Şifreyi Onaylad", "c-p", "Şifre", "", ""); // Yeni şifreyi onayla alanı
							$form->close("Şifre Değiştir"); // "Şifre Değiştir" düğmesi
							
							?> 
						</div> 
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
