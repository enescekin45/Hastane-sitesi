<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

?> 

<html>
<head>
	<title><?php echo Patient::get($_GET['patient'], "name")." - ".$_GET['patient']; ?> </title> <!-- Sayfa başlığı -->
	<?php require_once "inc/head.inc.php";  ?> <!-- Başlık kısmını içeri aktar -->

	<script> 
		$(function(){
			$("body").on("click", ".print-p-data", function(){
				$.print(".print-data"); // Print butonuna tıklandığında belgeyi yazdır
			});
		}); 
	</script>
	
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> <!-- Başlık bölümünü içeri aktar -->
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- Yan çubuğu içeri aktar -->
			<div class='col-md-7'>
				<div class='content-area'> 
					<div class='content-header'> 
						Yazdır <small>İlaç tahsilatı için bu hasta makbuzunu yazdırın</small> <!-- Başlık ve alt başlık -->
					</div>
					<div class='content-body'> 
						<?php Patient::printP($_GET['patient']); ?> <!-- Hasta bilgilerini yazdırmak için fonksiyonu çağır -->
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
