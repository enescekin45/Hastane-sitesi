<?php 
require_once "importance.php"; // Gerekli dosyaları dahil eder

if(!User::loggedIn()){ // Kullanıcı girişi yapılmamışsa
	Config::redir("login.php"); // Kullanıcıyı login.php sayfasına yönlendirir
}
?> 

<html>
<head>
	<title>Doktor Ekle - <?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
	<?php require_once "inc/head.inc.php";  ?> <!-- Head içeriğini dahil eder -->
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?>  <!-- Header içeriğini dahil eder -->
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- Sol kenar çubuğu -->
			<div class='col-md-7'>
				<div class='content-area'> 
				<div class='content-header'> 
					<?php 
						if(isset($_GET['token'])){ // URL'de 'token' parametresi varsa
							echo "Doktoru Düzenle <small>Edit this doctor</small>"; // Doktoru düzenleme modunda başlık
						} else { // 'token' parametresi yoksa
					?> 
					Doktor Ekle <small>Doktorları sisteme ekleyin</small> <!-- Yeni doktor ekleme modunda başlık -->
					<?php } ?> 
				</div>
				<?php require_once "inc/alerts.inc.php";  ?>  <!-- Uyarıları içeren dosyayı dahil eder -->
				<div class='content-body'> 
						
					<?php Messages::info("Varsayılan şifre <strong>Hastane</strong>"); ?>  <!-- Bilgi mesajı görüntüler -->
					<div class='form-holder'> <!-- Form alanı -->
						<?php 
							// Form alanları için varsayılan değerler
							$firstName = ""; 
							$secondName = "";
							$email = ""; 
							$phone = ""; 
							$role = ""; 
							$gender = ""; 
							$token = "";
							if(isset($_GET['token'])){ // URL'de 'token' parametresi varsa
								$token = $_GET['token'];
								// Doktor bilgilerini alır
								$firstName = User::get($token, "firstName"); 
								$secondName = User::get($token, "secondName");
								$email = User::get($token, "email"); 
								$phone = User::get($token, "phone"); 
								$role = User::get($token, "role"); 
								$gender = User::get($token, "gender"); 
							}
							if(isset($_POST['fn'])){ // Form gönderildiğinde
								$firstName = $_POST['fn']; // İlk isim
								$secondName = $_POST['sn']; // İkinci isim
								$email = $_POST['em']; // E-posta
								$phone = $_POST['phone']; // Telefon
								$role = $_POST['role']; // Rol
								if($token == ""){
									$gender = $_POST['gender']; // Cinsiyet
								} else {
									$gender = "$gender"; 
								}
								// Alanların boş olup olmadığını kontrol eder ve hata mesajı gösterir
								if($firstName == "" || $secondName == "" || $email == "" || $phone == "" || $role == "" || $gender == ""){
									Messages::error("Tüm alanları doldurmalısınız"); 
								} else if (strlen($phone) != 10) {
									Messages::error("Telefon 10 karakter olmalıdır");
								} else if (strpos($email, "@") === false && strpos($email, ".")) {
									Messages::error("Geçersiz e-posta girdiniz. E-posta example@example.com adresine bildirilmelidir.");
								} else {
									Doctor::add($token, $firstName, $secondName, $email, $phone, $gender, $role); // Yeni doktor ekler veya mevcut doktoru günceller
								}
							}
							$form = new Form(3, "post"); // Form oluşturur
							$form->init(); 
							$form->textBox("İlk İsim", "fn", "text", "$firstName", ""); // İlk isim alanı
							$form->textBox("İkinci İsim", "sn", "text", "$secondName", ""); // İkinci isim alanı
							$form->textBox("Email", "em", "text", "$email", ""); // E-posta alanı
							$form->textBox("Telefon", "telefon", "number", "$phone", ""); // Telefon alanı
							$form->textBox("Role e.g <i>Surgeon</i>", "role", "text", "$role", ""); // Rol alanı
							if(isset($_GET['token'] )){ // 'token' parametresi varsa
								$form->textBox("Cinsiyet", "", "text", "$gender", array("disabled")); // Cinsiyet alanı (devre dışı)
							} else { // 'token' parametresi yoksa
								$form->select("Cinsiyet", "Cinsiyet", "", array("Erkek", "Kadın", "Diğer")); // Cinsiyet seçim alanı
							}
							if(isset($_GET['token'] )){ // 'token' parametresi varsa
								$form->close("Doktoru Düzenle"); // Doktoru düzenleme modunda formu kapatır
							} else { // 'token' parametresi yoksa
								$form->close("Doktor Ekle"); // Yeni doktor ekleme modunda formu kapatır
							}
						?> 
					</div> 
				</div>
				</div> 
				
			</div>

			<div class='col-md-3'>
				<img src='images/doc-background-one.png' class='img-responsive' /> <!-- Doktor resmi -->
			</div> 
				
		</div> 
	</div> 
</body>
</html>
