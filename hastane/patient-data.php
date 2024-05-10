<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

?> 

<html>
<head>
	<title>Hasta Verileri - <?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
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
						Hasta Verileri <small>bu sizin verileriniz</small> <!-- Başlık ve alt başlık -->
					</div>
					<div class='content-body'> 
						<div class='form-holder'> 
							<hr />
							<?php Patient::getPatientData($_SESSION['patient']); ?> <!-- Hastanın verilerini getirme fonksiyonunu çağır -->
						</div> 
					</div>
				</div> 
			</div>	
		</div> 
	</div> 
</body>
</html>
