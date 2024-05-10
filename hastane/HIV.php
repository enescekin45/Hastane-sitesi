<?php 
// Önemli dosyaları içeri aktar
require_once "importance.php"; 

// Kullanıcı girişi yapılmamışsa, kullanıcıyı giriş sayfasına yönlendir
if(!User::loggedIn()){
	Config::redir("login.php"); 
}
?> 

<html>
<head>
	<!-- Sayfa başlığı -->
	<title>İnsan Bağışıklık Yetmezliği Virüsü - <?php echo CONFIG::SİSTEM_ADI; ?></title>
	<?php require_once "inc/head.inc.php";  // Başlık etiketinin içeriği ?> 
</head>
<body>
	<?php require_once "inc/header.inc.php"; // Başlık bölümünün içeriği ?> 
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; // Kenar çubuğunun içeriği ?></div> <!-- Kenar çubuğu -->
			<div class='col-md-7'>
				<div class='content-area'> 
					<div class='content-header'> 
						<!-- Sayfa başlığı ve alt başlık -->
						<h2>HIV <small>İnsan Bağışıklık Yetmezliği Virüsü</small></h2>
					</div>
					<div class='content-body'> 
						<!-- İçerik gövdesi -->
						<?php 
						// Bilgilendirme mesajı
						Messages::info("HIV ile yaşayan kişilerin bilgileri. Bu, muranga'da HIV farkındalığına ilişkin kampanyalar sırasında hastaneye yardımcı olacaktır"); 
						
						// Veri ekleme formu
						?>
						<div class='form-holder'> 
							<?php 
							// Post isteği varsa
							if(isset($_POST['name']) ){
								$name = $_POST['name']; 
								$age = $_POST['age']; 
								$location = $_POST['location'];
								$mod = $_POST['m-o-c']; 
								$comments = $_POST['d-comment']; 
								
								// Boş alan kontrolü
								if($name == "" || $age == "" || $location == "" || $mod == ""){
									Messages::error("En çok tüm alanları doldurursunuz");
								} else {
									// Veri ekleme işlemi
									HIV::add($name, $age, $location, $mod, $comments);
								}
							}
							
							// Özel form oluşturma
							Db::formSpecial(
								array("Adın", "Yaş", "Konum",  "Kasılma Modu"), // Form alanlarının etiketleri
								3, // Sütun sayısı
								array("name", "age", "location", "m-o-c"), // Alan adları
								array("text", "text", "text", 'text'),  // Alan türleri  
								array("Doktor Yorumu"), // Ekstra alanların etiketleri
								array('d-comment'),  // Ekstra alanların adları
								"", // Form action
								"", // Form method
								"",  // Ekstra sınıflar
								"Veri Ekleme" // Buton etiketi
							);
							?> 
						</div> 
					</div>
				</div> 
				
			</div>

			<div class='col-md-3'>
				<img src='images/doc-background-one.png' class='img-responsive' />  <!-- Resim -->
			</div> 
				
		</div> 
	</div> 
</body>
</html>
