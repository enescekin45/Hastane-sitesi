<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

if(!User::loggedIn()){
	Config::redir("login.php"); // Eğer kullanıcı oturum açmamışsa, giriş sayfasına yönlendir
}
?> 

<html>
<head>
	<title>Yeni Hasta <?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
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
						Yeni Hasta <small>Yeni hasta</small> <!-- Başlık ve alt başlık -->
					</div>
					<div class='content-body'> 
						<div class='form-holder'> <br /> 
							<?php 
								if(isset($_POST['p-number'])){
									$number = $_POST['p-number']; 
									Patient::checkPatient($number); // Hastayı kontrol et
								}
								$form = new Form(2, "post"); // Form oluştur
								$form->init();
								$form->textBox("Hasta Numarası", "p-number", "number",  "", ""); // Hasta numarası giriş kutusu
								$form->close("Numara Gönder"); // Formu kapat ve "Submit Number" düğmesini ekle
								echo "
									<div class='row'>
										<div class='col-md-2'></div> 
										<div class='col-md-10'> 
											<h4><strong><a href='add-patient.php'>Yeni Hasta</a></strong></h4> <!-- Yeni hasta ekleme bağlantısı -->
										</div>
									</div>
								";
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
