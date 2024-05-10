<?php 
// Gerekli dosyaları dahil et
require_once "importance.php"; 

?> 

<html>
<head>
	<!-- Sayfa başlığı -->
	<title>Randevu Alın - <?php echo CONFIG::SİSTEM_ADI; ?></title>
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
						<h2>Randevu Alın <small>Belirli bir doktordan randevu alın</small></h2>
					</div>
					<div class='content-body'> 
						<div class='form-holder'><br /><br />
							<?php
								// Eğer form gönderildiyse
								if(isset($_POST['p-name'])){
									$name = $_POST['p-name']; 
									$number = $_POST['p-number']; 
									$phone = $_POST['p-phone']; 
									$message = $_POST['message'];
									$doctor = $_POST['a-doctor'];
									
									// Eğer mesaj veya doktor alanı boşsa
									if($message == "" || $doctor == ""){
										Messages::error("Tüm alanları doldurmalısınız");
									} else {
										// Randevu gönderme işlemini gerçekleştir
										Appointment::send($name, $number, $phone, $message, $doctor);
									}
								}
							
								$patient = $_SESSION['Hasta'];
								
								// Form nesnesini oluştur ve başlat
								$form = new Form(2, "post"); 
								$form->init(); 
								// Text kutusu ekle ve varsayılan değerleri atayarak sadece okunur yap
								$form->textBox("Ad Soyad", "p-isim", "text", Patient::getP($patient, "name"), array("readonly") );
								$form->textBox("Hasta Numarası", "p-numara", "numara", Patient::getP($patient, "number"), array("readonly") );
								$form->textBox("Telefon", "p-telefon", "nuamra", Patient::getP($patient, "phone"), array("readonly"));
								// Metin alanı ekle
								$form->textarea("Mesaj", "Mesaj", "" );
								// Doktorların listesini al ve seçim kutusu ekle
								Doctor::getArray("a-Doktor", 2);
								// Formu kapat ve butonla birlikte gönder
								$form->close("Randevu Alın");
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
