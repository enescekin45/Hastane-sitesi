<?php 
// importance.php dosyasını dahil et
require_once "importance.php"; 

// Eğer hasta verisi varsa patient-data.php sayfasına yönlendir
if(Patient::isPatientIn()){
	header("Location: patient-data.php");
	return; 
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
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
				<?php // İçerik başlığı ?>
				Hasta Verileri <small>Verilerinize erişin ve indirin</small> 
				</div>
				<div class='content-body'>
					<div class='form-holder'><br /><br />
						<?php 
							$phone = ""; 
							$number = "";
							
							// Eğer form gönderildiyse
							if(isset($_POST['phone'])){
								$phone = $_POST['phone']; 
								$number = $_POST['p-number'];
								
								// Hasta yetkilendirme işlemi yapılıyor
								Patient::authorize($phone, $number);
							}
							
							// Form oluşturuluyor
							$form = new Form(2, "post");
							$form->init();
							$form->textBox("Telefon Numarası", "phone", "number", "$phone", array("placeholder='Telefon Numarası'") ); // Telefon numarası giriş alanı
							$form->textBox("Hasta Numarası", "p-number", "number", "$number", array("placeholder='Hasta Numarası'") );	// Hasta numarası giriş alanı
							$form->close("Verilerinize Erişin"); // Form kapatılıyor
						?>
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
