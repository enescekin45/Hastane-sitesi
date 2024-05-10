<?php 
require_once "importance.php"; // Diğer dosyaları içeri aktar

// Kullanıcı giriş yapmışsa ana sayfaya yönlendir
if(User::loggedIn()){
	Config::redir("index.php"); 
}
?> 

<html>
<head>
	<title>GİRİŞ - <?php echo CONFIG::SİSTEM_ADI; ?> </title> <!-- Sayfa başlığı, sistem adını içeriyor -->
	<?php require_once "inc/head.inc.php";  ?> <!-- Başlık bölümünü içeri aktar -->
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> <!-- Başlık kısmını içeri aktar -->
	<div class='container-fluid' >
		<div class='row'>
			<div class='col-md-3'> 
				<img src='images/doc-background-two-right.png' class='img-responsive' /> <!-- Yan çubukta (sidebar) bir görüntü -->
			</div> <!-- Bu bir yan çubuk olmalı -->
			<div class='col-md-9'>
				<div class='content-area'> 
					<div class='content-header'> 
						Giriş <small>Sisteme erişmek için giriş yapın</small> <!-- Sayfa başlığı ve alt başlık -->
					</div>
					<div class='content-body'> 

						<?php 
							if(isset($_GET['attempt'])){
							
								$status = $_GET['attempt']; // Giriş denemesinin türünü belirle

								if($status == 1){
									$header = "Yönetici Olarak Giriş Yapın";  // Başlık, yönetici girişi olacaksa
								} else {
									$header = "Doktor Olarak Giriş Yapın";  // Başlık, doktor girişi olacaksa
								}

								echo "<center><div class='badge-header'>$header</div></center>"; // Başlık etiketini ekrana yazdır

								if(isset($_POST['login-email'])){
									$email = $_POST['login-email']; 
									$password = $_POST['login-password'];

									if($email == "" || $password == ""){
										Messages::error("Tüm alanları doldurmalısınız"); // Hata mesajı göster
									} else {
										User::login($email, $password, $status); // Kullanıcı giriş fonksiyonunu çağır
									}

								}

							?> 
							<div class='row'>
								<div class='col-md-3'></div>
								<div class='col-md-6'>
									<div class='form-holder'>
										<?php Db::form(array("Email", "Password"), 3, array("login-email", "login-password"), array("text", "password"), "Login"); ?> <!-- Giriş formunu oluştur -->
									</div>
								</div> 
								<div class='col-md-3'></div>
							</div> 
							<?php 
								
							} else {

						?>

						<center><div class='badge-header'>Farklı Giriş Yap:</div></center> <!-- Alternatif giriş seçeneklerinin başlığı -->
						<div class='row'>
							<div class='col-md-2'></div>
							<div class='col-md-8'> 
								<div class='row' style='margin-top: 70px;'> 
									<div class='col-md-4'>
										<center>
											<div class='img-login-icons'>
												<img  class='img-responsive' src='images/3678411 - hospital medical nurse.png' alt='login as a doctor' />
											</div>
											<center><a href='login.php?attempt=1'><div class='badge-header'>Yönetici</div></a></center> <!-- Yönetici giriş linki -->
										</center> 
									</div> 
									<div class='col-md-4'> 

										<center>
											<div class='img-login-icons'>
												<img  class='img-responsive' src='images/3678412 - doctor medical care medical help stethoscope.png' alt='login as a doctor' />
											</div>
											<center><a href='login.php?attempt=2'><div class='badge-header'>Doktor</div></a></center> <!-- Doktor giriş linki -->
										</center>
									</div> 
									
									<div class='col-md-4'> 

										<center>
											<div class='img-login-icons'>
												<img  class='img-responsive' src='images/3678443 - ambulance fast fast hospital.png' alt='login as a doctor' />
											</div>
											<center><a href='login-patient.php'><div class='badge-header'>Hasta</div></a></center> <!-- Hasta giriş linki -->
										</center>
									</div> 
									
								</div> 
							</div> 
							<div class='col-md-2'></div>
							<?php } ?> 
						</div>
					</div> 
				</div>  
			</div> 
		</div> 
	</div> 
</body>
</html>
