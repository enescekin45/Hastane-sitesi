<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

if(!User::loggedIn()){
	Config::redir("login.php"); // Kullanıcı oturum açmamışsa, giriş sayfasına yönlendir
}
?> 

<html>
<head>
	<title>Yanıtla <?php echo "Patient Number: ".$_GET['patient']; ?> <?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
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
						Hasta numarasına yanıt verin <?php echo $_GET['patient']; ?> <small>cevap randevu</small> <!-- Başlık ve alt başlık -->
					</div>
					<div class='content-body'> 
						<div class='form-holder'>
							<br /><br /> 
							<?php 
							
							if(isset($_POST['doc-message'])){
								$message = $_POST['doc-message']; 
								Appointment::reply($message, $_GET['patient']); // Randevuya yanıt verme fonksiyonunu çağır
							}
							
							$form = new Form(2, "post"); // Form nesnesini oluştur
							$form->init(); 
							$form->textarea("Message", 'doc-message', ""); // Mesaj alanı
							$form->close("Cevap Randevu"); // "Cevap Randevu" düğmesi
							
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
